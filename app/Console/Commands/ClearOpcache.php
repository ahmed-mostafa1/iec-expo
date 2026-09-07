<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearOpcache extends Command
{
    protected $signature = 'opcache:clear';

    protected $description = 'Reset PHP OPcache, if enabled, so newly deployed code takes effect immediately';

    public function handle(): int
    {
        if (! function_exists('opcache_reset')) {
            $this->info('OPcache is not enabled on this server — nothing to do.');

            return self::SUCCESS;
        }

        if (opcache_reset()) {
            $this->info('OPcache cleared.');

            return self::SUCCESS;
        }

        $this->error('OPcache reset failed (it may be disabled for CLI via opcache.enable_cli).');

        return self::FAILURE;
    }
}
