@extends('admin.layouts.app')

@section('content')

    <div class="container">

        @include('admin.alert')

        <h2>List Of Categories ( {{ $categories->total() }} )</h2>

        @include('admin.partials.searchInput')

        <table class="table table-striped">

            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                    <td>
                        <edit-input :category="{{ $category }}"></edit-input>
                        <form action="/admin/category/{{ $category->id }}" method="POST" style="display: inline-block">
                            <button class="btn btn-danger" type="submit" onClick="javascript: return confirm('Are You Sure ?');">Delete</button>
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>


        </table>

        <category-modal></category-modal>

        {{ $categories->links() }}
    </div>

@endsection