@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-11 col-lg-offset-1">
            <a href="{{ route('admin.venues.create') }}" class="btn btn-success pull-right">
                <span class="glyphicon glyphicon-plus-sign"></span> New Venue
            </a>
            <br><br>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($venues as $venue)
                <tr>
                    <td>{{ $venue->name }}</td>
                    <td><a href="{{ $venue->url }}">{{ $venue->url }}</a></td>
                    <td>
                        <a href="{{ route('admin.venues.edit', ['id' => $venue->id]) }}" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="{{ route('admin.venues.delete', ['id' => $venue->id]) }}" class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-remove"></span> Delete
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop