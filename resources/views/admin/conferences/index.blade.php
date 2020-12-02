@extends('admin.layouts.app')

@section('content')

<div class="container">

    @include('admin.alert')

    <h2>List Of Conferences ( {{ $conferences->total() }} )</h2>

    @include('admin.partials.searchInput')

    <table class="table table-striped">

        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Youtube Id</th>
                <th>Created At</th>
                <th>Duration</th>
                <th>Valid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conferences as $conf)
            <tr class="@if(count($conf->categories) == 0) no-categories @endif">
                <td>{{ $conf->id }}</td>
                <td>
                    {{ str_limit($conf->title, 100, '...') }}
                    <div class="categories">@foreach($conf->categories as $category) <div class="label label-default">{{ $category->name }}</div> @endforeach</div>
                </td>
                <td>{{ $conf->youtube_id }}</td>
                <td>{{ $conf->created_at->format('d/m/Y') }}</td>
                <td>{{ $conf->duration }}</td>
                <td>{{ $conf->is_valid ? 'true' : 'false' }}</td>
                <td>
                    <a href="/admin/conference/{{ $conf->id }}/edit" class="btn btn-info">Edit</a>
                    <form action="/admin/conference/{{ $conf->id }}" method="POST" style="display: inline-block">
                        <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>


    </table>

    {{ $conferences->links() }}
</div>

@endsection