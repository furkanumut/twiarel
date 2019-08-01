<?php

namespace App\Listeners;

use App\Events\ArticleCommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Comment;

class SendCommentNotifictionToParentCommentOwner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleCommentCreated  $event
     * @return void
     */
    public function handle(ArticleCommentCreated $event)
    {
    }
}
