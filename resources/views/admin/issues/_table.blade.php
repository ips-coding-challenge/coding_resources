<table class="table table-striped">
    <thead>
        <tr>
            <th>id</th>
            <th>title</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($data as $d)
            <td>{{ $d->id }}</td>
            <td>{{ $d->title }}</td>
            @endforeach
        </tr>
    </tbody>
</table>