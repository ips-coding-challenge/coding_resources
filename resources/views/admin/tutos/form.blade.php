<h2>@if($tuto){{ "Edit" }}@else{{ "Add" }}@endif Tuto</h2>
<form action="@if($tuto !== null) {{ url('/admin/tuto', ['tuto' => $tuto]) }} @else {{ url('/admin/tuto') }}@endif"
    method="POST">

    @if($tuto)
    {{ method_field('PUT') }}
    @endif

    {{ csrf_field() }}

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="@if(old('title')){{ old('title') }} @elseif($tuto){{ $tuto->title }}@endif">
    </div>

    <div class="form-group">
        <label for="link">Youtube Link</label>
        <input type="text" name="link" id="link" class="form-control" value="@if(old('link')){{old('link')}} @elseif($tuto){{ "http://www.youtube.com/watch?v=".$tuto->youtube_id }}@endif">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control">@if(old('description')){{old('description')}} @elseif($tuto){{ $tuto->description }}@endif</textarea>
    </div>

    <div class="form-group">
        <label for="categories">Categories</label>
        <categories-input :categories="{{json_encode($categories)}}" @if($tuto) old-categories="{{ $tuto->categories}}"
            @endif></categories-input>

    </div>

    <div class="form-group">
        <label for="langue">Langue</label>
        <select name="langue" id="langue" class="form-control">
            <option value="0">Choose a language</option>
            @foreach($langues as $langue)
            <option value="{{$langue->id}}" @if($tuto) {{ $tuto->langue_id === $langue->id ? 'selected': '' }} @endif>{{
                $langue->name }}</option>
            @endforeach
        </select>
    </div>

    <tuto-parts-form :parts=" @if(old('parts')){{ json_encode(old('parts'))}} @else {{ $parts }} @endif"></tuto-parts-form>

    <div class="form-group">
        <button class="btn btn-primary">Send</button>
    </div>


</form>