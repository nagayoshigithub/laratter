<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
  public function index()
  {
    // 🔽 liked のデータも合わせて取得するよう修正
    $tweets = Tweet::with(['user', 'liked'])->latest()->get();
    // dd($tweets);
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
      $tweet->load('comments');
      return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
     return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Tweet $tweet)
    {
    $request->validate([
      'tweet' => 'required|max:255',
    ]);

    $tweet->update($request->only('tweet'));

    return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
     $tweet->delete();

     return redirect()->route('tweets.index');
    }
    public function search(Request $request)
    {

    $query = Tweet::query();
    if ($request->filled('keyword')) {
      $keyword = $request->keyword;
      $query->where('tweet', 'like', '%' . $keyword . '%');
    }
  // ページネーションを追加（1ページに10件表示）
    $tweets = $query
      ->latest()
      ->paginate(10);

    return view('tweets.search', compact('tweets'));
    }
}
