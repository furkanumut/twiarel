<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Events\ArticleCommentCreated;
use App\Helpers\Mahmut;
use App\Http\Controllers\Controller;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Mahmut $mahmut)
    {
        //$mahmut = new Mahmut();
        //return $mahmut->konus();
        $articles = Article::latest()->paginate(32);
        //return view("articles.index")->with("articles",$articles);
        return view("articles.index", compact('articles'));
    }

    public function create()
    {
        /*
        articles klaöründe crate.blade.php yi arar
         */

        $popularArticles = Article::latest()->limit(10)->get();
        return view("articles.create")->with("populararticles", $popularArticles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
            'tags' => 'nullable|string',
        ]);

        $image = $request->file('image')->store('public/article-image');
        $slug = Str::slug($request->title, '-');

        $m = new Article();
        $m->title = $request->title;
        $m->content = $request->content;
        $m->slug = $slug;
        $m->image = $image;
        $m->user_id = Auth::id();
        $m->save();

        if ($tagInput = $request->input('tags')) {
            $tags = explode(',', trim($tagInput));
            $tagIDsToAttach = [];
            foreach ($tags as $tag):
                $tagInfo = Tag::firstOrCreate(['tag' => $tag]);
                $tagIDsToAttach[] = $tagInfo->id;

                // sync kullanmamak istiyorsan şunu kullanabilirsin
                // $m->tags()->attach($tagInfo);//$tagInfo olayı da direk etiket modelini veriyorsun
            endforeach;
            $m->tags()->sync($tagIDsToAttach);
        }
        return redirect()->route("article.detail", [$slug]);
    }

    public function detail(Article $article)
    {

        //$article = Auth::user()->articles()->findOrFail($id);

        //dd($article);

        $lastArticles = Article::latest()->limit(10)->get();
        return view('articles.detail', compact('article', 'lastArticles'));
    }

    public function edit(Article $article)
    {
        //$article = Article::findOrFail($id);

        $popularArticles = Article::latest()->limit(10)->get();
        return view('articles.edit')->with("article", $article)->with("populararticles", $popularArticles);
    }

    public function editstore($id, Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
            'tags' => 'nullable|string',
        ]);

        $article = Auth::user()->articles()->findOrFail($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->user_id = Auth::id();

        if ($request->file('image')) {
            $image = $request->file('image')->store('public/article-image');
            $m->image = $image;
        }

        $article->save();

        $tagIDsToAttach = [];
        if ($tagInput = $request->input('tags')) {
            $tags = explode(',', trim($tagInput));
            $tags = array_unique(array_map('trim', (explode(',', $tagInput))));

            foreach ($tags as $tag):
                $tagInfo = Tag::firstOrCreate(['tag' => $tag]);
                $tagIDsToAttach[] = $tagInfo->id;

                // sync kullanmamak istiyorsan şunu kullanabilirsin
                // $m->tags()->attach($tagInfo);//$tagInfo olayı da direk etiket modelini veriyorsun
            endforeach;
        }
        $article->tags()->sync($tagIDsToAttach);

        return redirect()->route('article.edit', $id)->with('status', __('Article Updated'));

    }

    public function delete($id, Request $request)
    {
        $article = Auth::user()->articles()->findOrFail($id);
        $article->tags()->sync([]);
        $article->comments()->delete();
        $article->delete();
        return redirect()->route('article.index')->with('status', __('Article Deleted'));
    }

    public function addComment(Article $article, Request $request)
    {
        $request->validate([
            'body' => 'required|min:5',
            'parent_id' => 'nullable|integer',
        ]);

        $comment = new Comment();
        $comment->body = $request->input('body');
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = ($request->input('parent_id') ? $request->input('parent_id') : 0);
        $commentInfo = $article->comments()->save($comment);
        event(new ArticleCommentCreated($article, $comment));
        return redirect()->route('article.detail', $article->slug)->with('status', __('Comment Added'));
    }

    public function deleteComment($id)
    {
        $comment = Auth::user()->comments()->findOrFail($id);
        $articleSlug = $comment->article->slug;
        return redirect()->route('article.detail', $articleSlug)->with('status', __('Comment Deleted'));
    }

    public function listTagArticles(Tag $tag)
    {
        return view('articles.tagarticles')->with("tag", $tag);
    }
}
