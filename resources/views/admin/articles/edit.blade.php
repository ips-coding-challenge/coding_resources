@extends('admin.layouts.app')

@section('content')

    <div class="container">
        @include('admin.articles.form', ['article' => $article])
    </div>

@endsection