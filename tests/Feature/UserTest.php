<?php

use App\Models\User;

test('検索キーワードが指定されていない場合、すべてのユーザーを表示する', function () {
    // ユーザー作成
    $users = User::factory()->count(3)->create();

    // ログインしてキーワードなしで検索ルートにアクセス
    $response = $this->actingAs($users->first())->get(route('users.search'));

    // すべてのユーザーが表示されていることを確認
    foreach ($users as $user) {
        $response->assertSee($user->name);
    }
});

test('検索キーワードが指定された場合、正しいユーザーを表示する', function () {
    // ユーザー作成
    $user = User::factory()->create(['name' => 'John Doe']);
    $otherUser = User::factory()->create(['name' => 'Jane Smith']);

    // ログインし、「John」を検索
    $response = $this->actingAs($user)->get(route('users.search', ['keyword' => 'John']));

    // 正しいユーザーが表示されていることの確認
    $response->assertSee('John Doe');
    $response->assertDontSee('Jane Smith');
});

test('該当するユーザーが見つからない場合、メッセージを表示する', function () {
    // ユーザー作成
    $user = User::factory()->create();

    // ユーザーとしてログインし、存在しないユーザーを検索
    $response = $this->actingAs($user)->get(route('users.search', ['keyword' => 'NonExistentUser']));

    // 「ユーザーが見つかりません」と表示されることを確認
    $response->assertSee('No users found.');
});
