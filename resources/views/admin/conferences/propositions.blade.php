@extends('admin.layouts.app')

@section('content')

    <div class="container">

        @include('admin.alert')
        
        <h2>Conferences | List of Propositions</h2>
        @if(count($propositions) > 0)
            <table class="table table-striped">

                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($propositions as $prop)
                    <tr>
                        <td>{{ $prop->id }}</td>
                        <td>{{ $prop->title }}</td>
                        <td>{{ $prop->youtube_id }}</td>
                        <td>{{ $prop->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="/admin/conference/{{$prop->id}}/edit" class="btn btn-info">Edit</a>
                            <form action="/admin/conference/{{ $prop->id }}" method="POST"
                                  style="display: inline-block">
                                <button class="btn btn-danger" type="submit"
                                        onClick="javascript: return confirm('Are You Sure ?');">Delete
                                </button>
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>

            {{ $propositions->links() }}

        @else
            <h4>It is empty! :/</h4>
        @endif
    </div>

@endsection