<?php

namespace App\Console\Commands;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveLinksOlderThanDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:old_links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the links older than 24 hours';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Link::where('created_at', '<', Carbon::parse('24 hours'))->delete();

        $this->info('Links deleted successfully');
    }
}
