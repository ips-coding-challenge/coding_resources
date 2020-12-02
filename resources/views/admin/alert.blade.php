@if(session('added'))
    <div class="alert alert-success">{{ session('added') }}</div>
@endif

@if(session('edited'))
    <div class="alert alert-success">{{ session('edited') }}</div>
@endif

@if (session('deleted'))
    <div class="alert alert-danger">{{ session('deleted') }}</div>
@endif

@if (session('danger'))
    <div class="alert alert-danger">{{ session('danger') }}</div>
@endif