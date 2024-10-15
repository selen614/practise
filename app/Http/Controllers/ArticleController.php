<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function showList()
    {
        // インスタンス生成
        $model = new Article();
        $articles = $model->getList();

        return view('list', ['articles' => $articles]);
    }

    public function showRegistForm()
    {
        return view('regist');
    }

    public function registSubmit(ArticleRequest $request)
    {
        //DBトランザクション
        DB::beginTransaction();

        try {
            //登録処理の呼び出し
            $model = new Article();
            $model->registArticle($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        // 処理が完了したらregistにリダイレクト
        return redirect(route('regist'));
    }
}
