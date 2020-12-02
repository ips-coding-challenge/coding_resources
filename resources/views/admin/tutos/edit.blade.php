@extends('admin.layouts.app')

@section('content')

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                            src="//www.youtube.com/embed/{{$tuto->youtube_id}}"></iframe>
                </div>
            </div>
         </div>

        <tuto-form :tuto="{{ $tuto }}" :langues="{{ $langues }}" :parts="{{ $parts }}"></tuto-form>

       



@endsection