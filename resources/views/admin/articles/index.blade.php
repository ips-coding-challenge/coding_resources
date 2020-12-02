@extends('admin.layouts.app')

@section('content')

<div class="container">

    @include('admin.alert')

    <h2>List Of Articles ( {{ $articles->total() }} )</h2>

    @include('admin.partials.searchInput')

    <table class="table table-striped">

        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Url</th>
                <th>Created At</th>
                <th>Valid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr class="@if(count($article->categories) == 0) no-categories @endif">
                <td>{{ $article->id }}</td>
                <td>{{ str_limit($article->title, 70, '...') }}
                    <div class="categories">
                        @foreach($article->categories as $category) <div class="label label-default">{{ $category->name }}</div> @endforeach
                    </div>
                </td>
                <td><a href="{{$article->url}}">{{ str_limit($article->url, 40, '...') }}</a></td>
                <td>{{ $article->created_at->format('d/m/Y') }}</td>
                <td>{{ $article->is_valid ? 'true' : 'false' }}</td>
                <td>
                    <a href="/admin/article/{{ $article->id }}/edit" class="btn btn-info">Edit</a>
                    <form action="/admin/article/{{ $article->id }}" method="POST" style="display: inline-block">
                        <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>


    </table>

    {{ $articles->links() }}
</div>

@endsection