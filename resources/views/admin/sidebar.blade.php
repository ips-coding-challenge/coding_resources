<nav class="left_sidebar">
    <ul>

        <h4>Propositions</h4>
        <li><a href="/admin/proposition/create">Add</a></li>

        <h4>Conferences</h4>
        <li><a href="/admin/conference/propositions">Pending @if(Request::get('conferencesCount') > 0)<span class="label label-info">{{ Request::get('conferencesCount') }}</span>@endif</a></li>
        <li><a href="/admin/conference">Listing</a></li>
        <li><a href="/admin/conference/create">Add</a></li>

        <h4>Articles</h4>
        <li><a href="/admin/article/propositions">Pending @if(Request::get('articlesCount') > 0)<span class="label label-info">{{ Request::get('articlesCount') }}</span>@endif</a></li>
        <li><a href="/admin/article">Listing</a></li>
        <li><a href="/admin/article/create">Add</a></li>

        <h4>Tutos</h4>
        <li><a href="/admin/tuto/propositions">Pending  @if(Request::get('tutosCount') > 0)<span class="label label-info">{{ Request::get('tutosCount') }}</span>@endif</a></li>
        <li><a href="/admin/tuto">Listing</a></li>

        <h4>Books</h4>
        <li><a href="/admin/book/propositions">Pending @if(Request::get('booksCount') > 0)<span class="label label-info">{{ Request::get('booksCount') }}</span>@endif</a></li>
        <li><a href="/admin/book">Listing</a></li>
        <li><a href="/admin/book/create">Add</a></li>

        <hr>

        <h4>Messages</h4>
        <li><a href="/admin/message">Listing @if(Request::get('messagesCount') > 0)<span class="label label-info">{{ Request::get('messagesCount') }}</span>@endif</a></li>

        <h4>Categories</h4>
        <li><a href="/admin/category">Listing</a></li>
        <h4>Issues</h4>
        <li><a href="/admin/issue">Listing</a></li>
        <li><a href="/admin/deleted-youtube-videos">Youtube Issues</a></li>
    </ul>
</nav>