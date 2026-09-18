<?php

namespace App\Console\Commands;

use App\Services\Workflow\WorkflowExcelValidator;
use Illuminate\Console\Command;

class ValidateWorkflowExcel extends Command
{
    protected $signature = 'workflow:validate-excel
                            {file : Path file Excel workflow master}';

    protected $description = 'Validate Workflow Master Excel before import';

    public function handle(WorkflowExcelValidator $validator): int
    {
        $file = $this->argument('file');

        $this->info('Validating Workflow Master Excel...');
        $this->newLine();

        $result = $validator->validate($file);

        if (!empty($result['summary'])) {
            $this->info('Excel Summary:');

            foreach ($result['summary'] as $sheet => $summary) {
                $this->line(
                    sprintf(
                        '  %-20s : %d rows',
                        $sheet,
                        $summary['rows']
                    )
                );
            }

            $this->newLine();
        }

        if (!empty($result['warnings'])) {
            $this->warn('Warnings:');

            foreach ($result['warnings'] as $warning) {
                $this->line("  - {$warning}");
            }

            $this->newLine();
        }

        if (!empty($result['errors'])) {
            $this->error('Validation FAILED:');

            foreach ($result['errors'] as $error) {
                $this->line("  - {$error}");
            }

            return self::FAILURE;
        }

        $this->info('Validation SUCCESS.');
        $this->info('Excel siap untuk proses import.');

        return self::SUCCESS;
    }
}
