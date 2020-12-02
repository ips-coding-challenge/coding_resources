@extends('admin.layouts.app')

@section('content')

    <div class="container">
        @include('admin.conferences.form', ['conference' => null])
    </div>

@endsection