<?php

namespace App\Http\Controllers;

use App\Notifications\Followed;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profileView(User $user)
    {
        $userArticles = $user->articles()->latest()->paginate(3);
        return view('articles.userarticles', compact('user', 'userArticles'));
    }

    public function profileUpdate(Request $user)
    {
        $request->validate([
            'displayname' => 'nullable|string|min:1|max:50',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:3000'
        ]);
        $user = $request->user();
        $user->displayname = $request->input('displayname');
        $user->birth_date = $request->input('birth_date');
        if ($request->hasFile('avatar')) {
            // @TODO: önce ki profil fotoğrafı kaldırılacak!
            $path = $request->file('avatar')->store('public/user-avatar');
            $user->avatar = $path;
        }
        $user->save();
        return redirect()->route('user.articles', $user);  
    }

    public function follow(User $user, Request $request)
    {
        $request->user()->follow($user);
        return redirect()->route('user.articles', $user);
    }

    public function unfollow(User $user, Request $request)
    {
        $request->user()->unfollow($user);
        return redirect()->route('user.articles', $user);
    }

    public function notification($notif,Request $request)
    {
        //->where('id', $notif)->first()
        $mark = $request->user()->notifications()->where('id', $notif)->firstOrFail();
        $mark->markAsRead();
        return redirect($mark->data['action']);
    }

}
