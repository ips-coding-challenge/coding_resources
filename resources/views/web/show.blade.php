@extends('web.layouts.web')

@section('seo')
{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
@endsection

@section('content')

<div class="mdl-layout" ref="mdl-layout">
    <!-- Navbar -->
    @include('web.partials.show_header', ['title' => $data->title ])

    <main class="mdl-layout__content">
        <div class="page-content">
            <!--<div class="mdl-grid">
                <div class="mdl-cell mdl-cell--middle haha"></div>
            </div>-->
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--10-col-desktop mdl-cell--1-offset-desktop mdl-cell--12-col">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $data->youtube_id }}"
                        frameborder="0" allowfullscreen id="youtubePlayer">
                    </iframe>
                    <!-- Meta -->
                    <div class="infos">
                        <h2 class="infos-channel">{{ $data->channel_name }}</h2>
                        <div class="infos-date">Added on
                            {{ \Carbon\Carbon::parse($data->published_at)->format('d M Y') }}</div>
                    </div>
                    <!-- Tags -->
                    <div class="tag__container">
                        @foreach($data->categories as $tag)
                        <span class="mdl-chip show-tag">
                            <span class="mdl-chip__text">{{ $tag->name }}</span>
                        </span>
                        @endforeach
                    </div>
                    <description description="{{ $data->description }}"></description>
                    @if($data->type === 'tuto' && count($data->tutoParts) > 0)
                    <tuto-parts :item="{{ json_encode($data) }}"></tuto-parts>
                    @endif
                    @if(count($suggestions) > 0)
                    <hr>
                    <h3>You could also like</h3>
                    <show-suggestions type="{{$data->type}}" :suggestions="{{ json_encode($suggestions) }}">
                    </show-suggestions>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

@endsection