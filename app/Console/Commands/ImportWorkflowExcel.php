<?php

namespace App\Console\Commands;

use App\Services\Workflow\WorkflowExcelImportService;
use Illuminate\Console\Command;

class ImportWorkflowExcel extends Command
{
    protected $signature = 'workflow:import-excel
                            {file : Path file Excel workflow master}
                            {--user= : User ID yang melakukan import}';

    protected $description = 'Import Workflow Master Excel ke database';

    public function handle(
        WorkflowExcelImportService $service
    ): int {
        $file = $this->argument('file');

        $userId = $this->option('user');

        $userId = $userId !== null
            ? (int) $userId
            : null;

        $this->info('Importing Workflow Master Excel...');
        $this->newLine();

        try {

            $result = $service->import(
                $file,
                $userId
            );

            $this->info('Import SUCCESS.');
            $this->newLine();

            $this->info('Imported rows:');

            foreach ($result['summary'] as $sheet => $count) {
                $this->line(
                    sprintf(
                        '  %-20s : %d rows',
                        $sheet,
                        $count
                    )
                );
            }

            $this->newLine();

            $this->info(
                'Workflow Master berhasil di-import ke database.'
            );

            return self::SUCCESS;

        } catch (\Throwable $e) {

            $this->error('Import FAILED.');
            $this->newLine();

            $this->error(
                $e->getMessage()
            );

            return self::FAILURE;
        }
    }
}
