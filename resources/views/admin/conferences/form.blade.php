<h2>@if($conference){{ "Edit" }}@else{{ "Add" }}@endif Conference</h2>
<form action="@if($conference !== null) {{ url('/admin/conference', ['conference' => $conference]) }} @else {{ url('/admin/conference') }}@endif"
    method="POST">

    @if($conference !== null)
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
        <input type="text" name="title" id="title" class="form-control" value="@if(old('title')){{ old('title') }} @elseif($conference){{ $conference->title }}@endif">
    </div>

    <div class="form-group">
        <label for="link">Youtube Link</label>
        <input type="text" name="link" id="link" class="form-control" value="@if(old('link')){{old('link')}} @elseif($conference){{ "http://www.youtube.com/watch?v=".$conference->youtube_id }}@endif">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control">@if(old('description')){{old('description')}} @elseif($conference){{ $conference->description }}@endif</textarea>
    </div>


    <div class="form-group">
        <label for="categories">Categories</label>
        <categories-input :categories="{{json_encode($categories)}}" @if($conference) old-categories="{{ $conference->categories}}"
            @endif></categories-input>

    </div>
    <!-- <div class="form-group">
        <label for="categories">Categories</label>
        <input type="text" name="categories" id="categories" class="form-control"
               value="@if(old('categories')){{ old('categories') }} @elseif($conference){{ $conference->categories }}@endif">
    </div> -->

    <div class="form-group">
        <label for="langue">Langue</label>
        <select name="langue" id="langue" class="form-control">
            <option value="0">Choose a language</option>
            @foreach($langues as $langue)
            <option value="{{$langue->id}}" @if($conference)
                {{ $conference->langue_id === $langue->id ? 'selected': '' }} @endif>{{ $langue->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Send</button>
    </div>


</form>