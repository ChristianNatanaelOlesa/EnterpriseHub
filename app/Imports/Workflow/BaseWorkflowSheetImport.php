<?php

namespace App\Imports\Workflow;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

abstract class BaseWorkflowSheetImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    protected Collection $rows;

    public function __construct()
    {
        $this->rows = collect();
    }

    public function collection(Collection $rows)
    {
        $this->rows = $rows->map(function ($row) {
            return collect($row)
                ->only($this->columns())
                ->map(function ($value) {
                    return $this->normalizeValue($value);
                })
                ->toArray();
        });
    }

    protected function normalizeValue($value)
    {
        if (is_string($value)) {
            $value = trim($value);

            /*
             * Excel hasil export Google Sheets dapat membawa
             * formula sebagai string literal seperti:
             *
             * =IFERROR(__xludf.DUMMYFUNCTION(...),"Requester ...")
             *
             * Untuk sementara ambil nilai fallback yang berada
             * di dalam argument terakhir formula IFERROR.
             */
            if (str_starts_with($value, '=IFERROR(')) {
                if (preg_match(
                    '/,"([^"]*)"\)$/',
                    $value,
                    $matches
                )) {
                    return $matches[1];
                }
            }
        }

        return $value;
    }

    public function getRows(): Collection
    {
        return $this->rows;
    }

    abstract protected function columns(): array;
}
