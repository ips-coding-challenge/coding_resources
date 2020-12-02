@extends('admin.layouts.app')

@section('content')

    <div class="container">
    	<quick-add-book :langues="{{ json_encode($langues) }}"></quick-add-book>
        {{-- @include('admin.books.form', ['book' => null]) --}}
    </div>

@endsection