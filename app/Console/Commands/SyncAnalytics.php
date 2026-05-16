<?php

namespace App\Console\Commands;

use App\Services\Analytics\GoogleAnalyticsSyncService;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Throwable;

class SyncAnalytics extends Command
{
    protected $signature = 'analytics:sync
        {--from= : Start date in YYYY-MM-DD format}
        {--to= : End date in YYYY-MM-DD format}
        {--force : Re-fetch and overwrite stored aggregate rows for the requested range}';

    protected $description = 'Sync Google Analytics aggregate reports into local analytics tables.';

    public function handle(GoogleAnalyticsSyncService $syncService): int
    {
        $dateFrom = CarbonImmutable::parse(
            $this->option('from') ?: config('services.google_analytics.import_start_date', '2020-01-01')
        );
        $dateTo = CarbonImmutable::parse($this->option('to') ?: today()->toDateString());

        if ($dateFrom->gt($dateTo)) {
            $this->error('The --from date must be before or equal to the --to date.');

            return self::FAILURE;
        }

        try {
            $run = $syncService->sync($dateFrom, $dateTo, (bool) $this->option('force'));
        } catch (Throwable $throwable) {
            $this->error($throwable->getMessage());

            return self::FAILURE;
        }

        $this->info("Analytics sync completed for {$run->date_from->toDateString()} through {$run->date_to->toDateString()}.");
        $this->line("Rows imported: {$run->rows_imported}");

        return self::SUCCESS;
    }
}
