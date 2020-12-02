@extends('admin.layouts.app')

@section('content')
    <div class="container messages__container">
        <h1>{{ $message->subject }}</h1>
        <div class="email">From: {{ $message->email }}</div>
        <hr>
        <div class="message">
            {!! nl2br(e($message->message)) !!}
        </div>
        <hr>
        <form action="/admin/message/{{ $message->id }}" method="POST" style="display: inline-block">
            <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
            {{ method_field('delete') }}
            {{ csrf_field() }}
        </form>
    </div>
    

@endsection