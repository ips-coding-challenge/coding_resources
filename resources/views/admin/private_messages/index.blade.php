@extends('admin.layouts.app')

@section('content')

<div class="container">

    @include('admin.alert')

    <h2>List Of Messages</h2>
    <hr>

    @if(count($messages) > 0)
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Email</th>
                <th>Subject</th>                
                <th>Message</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
            <tr class="@if($message->read == 0)not-read @endif">
                <td>{{ $message->email }}</td>
                <td>{{ str_limit($message->subject, 40, '...') }}</td>
                <td>{{ str_limit($message->message, 100, '...') }}</td>
                <td>{{ $message->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="/admin/message/{{ $message->id }}" class="btn btn-info">Read</a>
                    <form action="/admin/message/{{ $message->id }}" method="POST" style="display: inline-block">
                        <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>


    </table>

    @else
        <h4>No messages! </h4>
    @endif

    {{ $messages->links() }}
</div>

@endsection