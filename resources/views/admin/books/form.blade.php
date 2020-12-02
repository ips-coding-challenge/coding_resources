<h2>@if($book){{ "Edit" }}@else{{ "Add" }}@endif Book</h2>
<form action="@if($book !== null) {{ url('/admin/book', ['book' => $book]) }} @else {{ url('/admin/book') }}@endif"
    method="POST">

    @if($book !== null)
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
        <input type="text" name="title" id="title" class="form-control" value="@if(old('title')){{ old('title') }} @elseif($book){{ $book->title }}@endif">
    </div>

    <div class="form-group">
        <label for="author">Author</label>
        <input type="text" name="author" id="author" class="form-control" value="@if(old('author')){{ old('author') }} @elseif($book){{ $book->author }}@endif">
    </div>


    <div class="form-group">
        <label for="link">Link</label>
        <input type="url" name="link" id="link" class="form-control" value="@if(old('link')){{old('link')}} @elseif($book){{ "$book->link" }}@endif">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control">@if(old('description')){{old('description')}} @elseif($book){{ $book->description }}@endif</textarea>
    </div>

    <div class="form-group">
        <label for="cover">Cover</label>
        <input type="url" name="cover" id="cover" class="form-control" value="@if(old('cover')){{old('cover')}} @elseif($book){{ "$book->cover" }}@endif">
    </div>


    <div class="form-group">
        <label for="categories">Categories</label>
        <categories-input :categories="{{json_encode($categories)}}" @if($book) old-categories="{{ $book->categories}}"
            @endif></categories-input>

    </div>
    <div class="form-group">
        <label for="langue">Langue</label>
        <select name="langue" id="langue" class="form-control">
            <option value="0">Choose a language</option>
            @foreach($langues as $langue)
            <option value="{{$langue->id}}" @if($book) {{ $book->langue_id === $langue->id ? 'selected': '' }} @endif>{{
                $langue->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Send</button>
    </div>


</form>