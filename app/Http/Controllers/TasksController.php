<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $tasks = [];
        
        // 認証済みユーザを取得
        $user = \Auth::user();
        
        if (\Auth::check()){
            // タスク一覧を取得
            $tasks = $user->tasks()->paginate(25);
        }

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [
            'user' => $user,
            'tasks' => $tasks,
        ]);
    }

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        //検証
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        // メッセージを作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->user_id = $request->user()->id;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() == $task->user_id){
            // メッセージ詳細ビューでそれを表示
            return view('tasks.show', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
    }

    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() == $task->user_id){
            // メッセージ編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
    }

    // putまたはpatchでtasks/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        //検証
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() == $task->user_id){
            // メッセージを更新
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $message->user_id) {
            $message->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}