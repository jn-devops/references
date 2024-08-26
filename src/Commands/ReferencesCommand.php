<?php

namespace Homeful\References\Commands;

use Illuminate\Console\Command;

class ReferencesCommand extends Command
{
    public $signature = 'references';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
