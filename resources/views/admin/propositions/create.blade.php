@extends('admin.layouts.app')

@section('content')

    @include('admin.alert')

    <div class="row">
        <h2 class="text-center">Quick Link</h2>
        <div class="col-md-8 col-md-offset-2">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/admin/proposition') }}" method="POST">

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Choose a type</option>
                        @foreach($choices as $choice)
                            <option value="{{ $choice }}" @if(old('type') === $choice){{ "selected" }} @endif>{{ ucfirst($choice) }}</option>
                        @endforeach
                    </select>
                </div>

                <link-input-for-youtube old="{{ old('link') }}"></link-input-for-youtube>

                <title-input></title-input>

                {{-- <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
                </div> --}}

                {{--<div class="form-group">--}}
                    {{--<label for="link">Link</label>--}}
                    {{--<input type="text" id="link" name="link" class="form-control" value="{{ old('link') }}">--}}
                {{--</div>--}}


                {{ csrf_field() }}

                <button class="btn btn-primary" type="submit">Add</button>


            </form>
        </div>
    </div>
@endsection