@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-11 col-lg-offset-1">
<!--            <ol class="breadcrumb">-->
<!--                <li><a href="#">Home</a></li>-->
<!--                <li><a href="#">Library</a></li>-->
<!--                <li class="active">Data</li>-->
<!--            </ol>-->
            <a href="{{ route('admin.events.create') }}" class="btn btn-success pull-right">
                <span class="glyphicon glyphicon-plus-sign"></span> New Event
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
                        <th>Title</th>
                        <th>Begins</th>
                        <th>Ends</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->begins_at->format('m/d/Y g:ia') }}</td>
                        <td>{{ $event->ends_at->format('m/d/Y g:ia') }}</td>
                        <td>
                            @if ($event->link)
                            <a href="{{ $event->link }}" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-link"></span> Link
                            </a>
                            @endif
                            <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            <a href="{{ route('admin.events.destroy', ['id' => $event->id]) }}" class="btn btn-danger btn-xs">
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