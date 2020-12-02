@extends('admin.layouts.app')

@section('content')

<div class="container">

    @include('admin.alert')

    <h2>List Of Books ( {{ $books->total() }} )</h2>

    @include('admin.partials.searchInput')

    <table class="table table-striped">

        <thead>
            <tr>
                <th>Id</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Url</th>
                <th>Created At</th>
                <th>Valid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td><img class="img img-responsive" src="{{ $book->cover }}" alt="cover image" style="max-width:100px"></td>
                <td class="@if(count($book->categories) == 0) no-categories @endif">
                    {{ str_limit($book->title, 60, '...') }}
                    <div class="categories">
                        @foreach($book->categories as $category) <div class="label label-default">{{ $category->name }}</div> @endforeach
                    </div>
                </td>
                <td>{{ $book->author }}</td>
                <td><a href="{{$book->link}}">{{ str_limit($book->link, 30, '...') }}</a></td>
                <td>{{ $book->created_at->format('d/m/Y') }}</td>
                <td>{{ $book->is_valid ? 'true' : 'false' }}</td>
                <td>
                    <a href="/admin/book/{{ $book->id }}/edit" class="btn btn-info">Edit</a>
                    <form action="/admin/book/{{ $book->id }}" method="POST" style="display: inline-block">
                        <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>


    </table>

    {{ $books->links() }}
</div>

@endsection