<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleResource extends Controller
{

    public function __construct() {
        return $this->middleware('auth:api')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::latest()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
            'tags' => 'nullable|string',
        ]);
        $slug = Str::slug($request->title, '-');

        $m = new Article();
        $m->title = $request->title;
        $m->content = $request->content;
        $m->slug = $slug;
        $m->user_id = $request->user()->id;
        $m->save();
        if ($tagInput = $request->input('tags')) {
            $tags = explode(',', trim($tagInput));
            $tagIDsToAttach = [];
            foreach ($tags as $tag):
                $tagInfo = Tag::firstOrCreate(['tag' => $tag]);
                $tagIDsToAttach[] = $tagInfo->id;

            endforeach;
            $m->tags()->sync($tagIDsToAttach);
        }

        return $m;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return array(
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:5',
            'tags' => 'comma seperated string values'
        );
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
            'tags' => 'nullable|string',
        ]);
        if($article->user_id !== $request->user()->id)  return response()->json(['message'=>__('Senin yetkin yok, yazan silebilir cnm benim.')], 404);            
        $article->title = $request->title;
        $article->content = $request->content;
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

        return response()->json($article);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article,Request $request)
    {
        if ($request->user()->cant('delete', $article)) 
            return abort(403, "Bu makaleyi silme yetkiniz bulunmuyor.");
        return ['result' => $article->delete()];
        }
}
