<?php

namespace App\Services\Master;

use App\Models\Master\MsCoc;
use App\Repositories\Master\CocRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class CocService
{
    public function __construct(
        protected CocRepository $repository
    ) {
    }

    public function getAll(?string $search = null): LengthAwarePaginator
    {
        return $this->repository->getAll($search, 10);
    }

    public function find(string $id): MsCoc
    {
        return $this->repository->find($id) ?? abort(404);
    }

    public function create(array $data, $user): MsCoc
    {
        return DB::transaction(function () use ($data, $user) {
            $id = $this->generateId();

            if (!(($data['File'] ?? null) instanceof UploadedFile)) {
                throw new RuntimeException('File Code Of Conduct wajib diupload.');
            }

            $fileLoc = $this->storeFile($data['File'], $id);
            $now = now();
            $username = $user->Username;

            try {
                return MsCoc::create([
                    'CocID' => $id,
                    'Name' => $data['Name'],
                    'Description' => $data['Description'],
                    'Contents' => $data['Contents'],
                    'FileLoc' => $fileLoc,
                    'InputDate' => $now,
                    'InputUser' => $username,
                    'ModifDate' => $now,
                    'ModifUser' => $username,
                ]);
            } catch (\Throwable $e) {
                Storage::disk('public')->delete($fileLoc);
                throw $e;
            }
        });
    }

    public function update(string $id, array $data, $user): MsCoc
    {
        return DB::transaction(function () use ($id, $data, $user) {
            $coc = MsCoc::query()
                ->where('CocID', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldFile = $coc->FileLoc;
            $fileLoc = $oldFile;
            $newFileUploaded = false;

            if (($data['File'] ?? null) instanceof UploadedFile) {
                $fileLoc = $this->storeFile($data['File'], $id);
                $newFileUploaded = true;
            }

            try {
                $now = now();

                $coc->update([
                    'Name' => $data['Name'],
                    'Description' => $data['Description'],
                    'Contents' => $data['Contents'],
                    'FileLoc' => $fileLoc,
                    'ModifDate' => $now,
                    'ModifUser' => $user->Username,
                ]);

                if ($newFileUploaded && $oldFile && $fileLoc !== $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }

                return $coc->fresh();
            } catch (\Throwable $e) {
                if ($newFileUploaded && $fileLoc !== $oldFile) {
                    Storage::disk('public')->delete($fileLoc);
                }
                throw $e;
            }
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $coc = MsCoc::query()
                ->where('CocID', $id)
                ->firstOrFail();

            $fileLoc = $coc->FileLoc;
            $coc->delete();

            if ($fileLoc) {
                Storage::disk('public')->delete($fileLoc);
            }
        });
    }

    private function storeFile(UploadedFile $file, string $cocId): string
    {
        $directory = 'code-of-conduct/' . $cocId;

        $baseName = Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        );

        $baseName = $baseName !== '' ? $baseName : 'document';

        $filename = now()->format('YmdHis')
            . '_'
            . $baseName
            . '.'
            . strtolower($file->getClientOriginalExtension());

        return $file->storeAs($directory, $filename, 'public');
    }

    private function generateId(): string
    {
        $lastId = MsCoc::query()
            ->where('CocID', 'like', 'COC%')
            ->orderByDesc('CocID')
            ->value('CocID');

        $number = 0;

        if ($lastId && preg_match('/^COC(\d{3})$/', $lastId, $matches)) {
            $number = (int) $matches[1];
        }

        do {
            $number++;

            if ($number > 999) {
                throw new RuntimeException('Nomor Code Of Conduct sudah mencapai batas COC999.');
            }

            $id = 'COC' . str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        } while (MsCoc::query()->where('CocID', $id)->exists());

        return $id;
    }
}
