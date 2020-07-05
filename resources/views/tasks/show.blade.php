@extends('layouts.app')

@section('content')
    @if (Auth::id() == $task->user_id)
        <table class="table table-bordered">
            <tr>
                <td>{{ $task->content }}</td>
                <td>{{ $task->status }}</td>
            </tr>
        </table>
    
        {{-- タスク編集ページへのリンク --}}
        {!! link_to_route('tasks.edit', 'このタスクを編集', ['task' => $task->id], ['class' => 'btn btn-light']) !!}
    
        {{-- タスク削除フォーム --}}
        {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @endif
@endsection