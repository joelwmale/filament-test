<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Jobs\TweetPostJob;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $blogPost = BlogPost::find(17);

        dispatch_sync(new TweetPostJob($blogPost));
    }
}
