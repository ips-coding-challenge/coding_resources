@extends('admin.layouts.app')

@section('content')

    <div class="container">
        @include('admin.books.form', ['book' => $book])
    </div>

@endsection