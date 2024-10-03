<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // Userモデルを使うために追加

class UserController extends Controller
{
    // 検索機能
    public function search(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // キーワードに基づいてユーザーを検索
        if (!empty($keyword)) {
            // キーワードがある場合
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        } else {
            // キーワードがない場合は全ユーザーを取得
            $users = User::paginate(10);
        }

        // users.search ビューにデータを渡す
        return view('user.search', compact('users'));
    }
}
