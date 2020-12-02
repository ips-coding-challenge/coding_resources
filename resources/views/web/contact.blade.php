@extends('web.layouts.web')

@section('seo')
    {!! SEOMeta::generate() !!}
	{!! OpenGraph::generate() !!}
@endsection

@section('content')

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <!-- Alert -->
        @if(session('success'))
        <div class="custom-alert">{{ session('success') }}</div>
        @endif
	<!-- Navbar -->
	@include('web.partials.show_header', ['title' => "Contact me" ])

	<main class="mdl-layout__content contact__form">
         
		<div class="page-content">                
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--3-offset-desktop mdl-cell--12-col-tablet">
                    <h2>Contact me</h2>
                    <hr>
                    <form action="{{ route('contact.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if($errors->has('email')) is-invalid @endif">
                            <input class="mdl-textfield__input" type="email" name="email" value="{{ old('email')}}">
                            <label class="mdl-textfield__label" for="sample1">* Email</label>
                            @if($errors->has('email'))
                            <span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>    

                        <!-- Title -->
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if($errors->has('email')) is-invalid @endif">
                            <input class="mdl-textfield__input" type="text" name="subject" value="{{ old('subject')}}">
                            <label class="mdl-textfield__label" for="sample1">* Subject</label>
                            @if($errors->has('subject'))
                            <span class="mdl-textfield__error">{{ $errors->first('subject') }}</span>
                            @endif
                        </div> 

                        <!-- Message -->
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if($errors->has('message')) is-invalid @endif">
                            <textarea class="mdl-textfield__input" rows="7" type="text" name="message">{{old('message')}}</textarea>
                            <label class="mdl-textfield__label" for="sample1">* Message</label>
                            @if($errors->has('message'))
                            <span class="mdl-textfield__error">{{ $errors->first('message') }}</span>
                            @endif
                        </div> 
                        <div class="captcha_container">
                            <div class="mdl-textfield @if($errors->has('g-recaptcha-response')) is-invalid @endif">
                                <div class="g-recaptcha" data-sitekey="6LfCpzYUAAAAAA1DT-xZYIPxBnaY9ulpGamPfjcZ"></div>
                                @if($errors->has('g-recaptcha-response'))
                                <span class="mdl-textfield__error">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>
                        </div>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Send</button>
                    </form>
                </div>
            </div>
		</div>		
	</main>
</div>

@endsection

@section('js')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    const alert = document.querySelector('.custom-alert')
    if(alert !== null){
        setTimeout( function() {
            alert.classList.add('alert-hide')
        }, 2000)
    }
</script>
@endsection