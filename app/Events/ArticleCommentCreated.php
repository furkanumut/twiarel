<?php

namespace App\Events;

use App\Article;
use App\Comment;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ArticleCommentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article;
    public $comment;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Article $injectArticle,Comment $injectComment)
    {
        $this->article = $injectArticle;
        $this->comment = $injectComment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
