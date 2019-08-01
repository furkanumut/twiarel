<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Weather;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $userIdsToShowArticles = $request->user()->followees()->pluck('id')->toArray();
        $articles = Article::whereIn('user_id', $userIdsToShowArticles)->latest()->get();
        // $userArticles = $request->user()->articles()->paginate(2);
        return view('home')->with('articles', $articles);
        // return view('home', compact($articles));
    }

}
