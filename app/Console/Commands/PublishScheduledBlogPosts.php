<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class PublishScheduledBlogPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish-scheduled-blog-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes scheduled blog posts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $blogPosts = BlogPost::where('published_at', today())->get();

        $blogPosts->each(function (BlogPost $blogPost) {
            $blogPost->status = BlogPost::STATUS_PUBLISHED;
            $blogPost->save();
        });
    }
}
