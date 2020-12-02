@extends('admin.layouts.app')

@section('content')

        <div class="row">
            <div class="col-lg-4">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                            src="//www.youtube.com/embed/{{$conference->youtube_id}}"></iframe>
                </div>
            </div>

            <div class="col-lg-8">
                @include('admin.conferences.form', ['conference' => $conference])
            </div>
        </div>



@endsection