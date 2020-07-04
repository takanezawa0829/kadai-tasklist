@extends('layouts.app')

@section('content')

    @if (Auth::check())
    
        <h1>タスク一覧</h1>
    
        @if (count($tasks) > 0)
            <table class="table table-striped">
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        {{-- タスク詳細ページへのリンク --}}
                        <td>{!! link_to_route('tasks.show', $task->content, ['task' => $task->id]) !!}</td>
                        <td>{{ $task->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- タスク作成ページへのリンク --}}
        {!! link_to_route('tasks.create', '新規タスクの追加', [], ['class' => 'btn btn-primary']) !!}

    @else
    
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the TextLest</h1>
                
                {{-- ユーザ登録ページヘのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
                
                {{-- ログインページへのリンク --}}
                {!! link_to_route('login', 'Login!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
        
    @endif
@endsection