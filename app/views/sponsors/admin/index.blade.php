@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-11 col-lg-offset-1">
            <a href="{{ route('admin.sponsors.create') }}" class="btn btn-success pull-right">
                <span class="glyphicon glyphicon-plus-sign"></span> New Sponsor
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
                    <th>Type</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sponsors as $sponsor)
                <tr>
                    <td>{{ $sponsor->name }}</td>
                    <td><a href="{{ $sponsor->url }}">{{ $sponsor->url }}</a></td>
                    <td>{{ ucwords(str_replace('-', ' ', $sponsor->type)) }}</td>
                    <td>
                        @if (! is_null($sponsor->logo))
                        <a href="{{ asset('uploads/'.$sponsor->logo) }}" class="btn btn-default btn-xs" target="_blank">
                            <span class="glyphicon glyphicon-picture"></span> View Logo
                        </a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.sponsors.edit', ['id' => $sponsor->id]) }}" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="{{ route('admin.sponsors.delete', ['id' => $sponsor->id]) }}" class="btn btn-danger btn-xs">
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