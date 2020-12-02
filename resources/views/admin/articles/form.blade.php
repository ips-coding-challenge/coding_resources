<h2>@if($article){{ "Edit" }}@else{{ "Add" }}@endif Article</h2>
<form action="@if($article !== null) {{ url('/admin/article', ['article' => $article]) }} @else {{ url('/admin/article') }}@endif"
    method="POST">

    @if($article !== null)
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
        <input type="text" name="title" id="title" class="form-control" value="@if(old('title')){{ old('title') }} @elseif($article){{ $article->title }}@endif">
    </div>

    <div class="form-group">
        <label for="url">Url</label>
        <input type="text" name="url" id="url" class="form-control" value="@if(old('url')){{old('url')}} @elseif($article){{ "$article->url" }}@endif">
    </div>


    <div class="form-group">
        <label for="categories">Categories</label>
        <categories-input :categories="{{json_encode($categories)}}" @if($article) old-categories="{{ $article->categories}}"
            @endif></categories-input>

    </div>

    <!-- <div class="
            form-group">
            <label for="categories">Categories</label>
            <input type="text" name="categories" id="categories" class="form-control awesomplete" value="@if(old('categories')){{ old('categories') }} @elseif($article){{ $article->categories }}@endif">
    </div> -->

    <div class="form-group">
        <label for="langue">Langue</label>
        <select name="langue" id="langue" class="form-control">
            <option value="0">Choose a language</option>
            @foreach($langues as $langue)
            <option value="{{$langue->id}}" @if($article) {{ $article->langue_id === $langue->id ? 'selected': '' }}
                @endif>{{ $langue->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Send</button>
    </div>


</form>