@extends('admin.layouts.app')

@section('content')

<div class="container">

    @include('admin.alert')

    <h2>List Of Tutos ( {{ $tutos->total() }} )</h2>

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
            @foreach($tutos as $tuto)
            <tr class="@if(count($tuto->categories) == 0) no-categories @endif">
                <td>{{ $tuto->id }}</td>
                <td>{{ str_limit($tuto->title, 100, '...') }}
                    <div class="categories">
                        @foreach($tuto->categories as $category) <div class="label label-default">{{ $category->name }}</div> @endforeach
                    </div>
                </td>
                <td>{{ $tuto->youtube_id }}</td>
                <td>{{ $tuto->created_at->format('d/m/Y') }}</td>
                <td>{{ $tuto->duration }}</td>
                <td>{{ $tuto->is_valid ? 'true' : 'false' }}</td>
                <td>
                    <a href="/admin/tuto/{{ $tuto->id }}/edit" class="btn btn-info">Edit</a>
                    <form action="/admin/tuto/{{ $tuto->id }}" method="POST" style="display: inline-block">
                        <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>


    </table>

    {{ $tutos->links() }}
</div>

@endsection