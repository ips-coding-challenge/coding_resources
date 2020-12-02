@extends('admin.layouts.app')

@section('content')

    <div class="container">
        @include('admin.articles.form', ['article' => null])
    </div>

@endsection