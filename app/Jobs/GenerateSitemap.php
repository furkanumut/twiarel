<?php

namespace App\Jobs;

use App;
use App\Article;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sitemap = App::make("sitemap");

        $articles = Article::orderBy('created_at', 'desc')->get();
        foreach ($articles as $article) {
            $sitemap->add(route('article.detail', $article->slug), $article->updated_at, '0.9', 'weekly');
        }

        $users = User::All();
        foreach ($users as $user) {
            $sitemap->add(route('user.articles', $user), $article->updated_at, '0.9', 'daily');
        }

        $sitemap->store('xml', 'sitemap');
    }
}
