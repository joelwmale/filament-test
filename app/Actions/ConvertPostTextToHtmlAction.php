<?php

namespace App\Actions;

use App\Models\BlogPost;
use App\Services\CommonMark\CommonMark;

class ConvertPostTextToHtmlAction
{
    public function execute(BlogPost $blogPost): void
    {
        if (! $blogPost->content) {
            return;
        }

        $html = CommonMark::convertToHtml($blogPost->content, highlightCode: true);

        // find any twitter handles and convert them to links
        $html = preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="https://twitter.com/$1">@$1</a>', $html);

        $blogPost->update(['html' => $html]);
    }
}
