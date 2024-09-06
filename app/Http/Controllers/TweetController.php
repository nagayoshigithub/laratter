<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
  public function index()
  {
    // 🔽 追加
    $tweets = Tweet::with('user')->latest()->get();
    return view('tweets.index', compact('tweets'));
  }

  public function create()
  {
    // 🔽 追加
    return view('tweets.create');
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     $request->validate([
      'tweet' => 'required|max:255',
    ]);

    $request->user()->tweets()->create($request->only('tweet'));

    return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
      return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        //
    }
}
