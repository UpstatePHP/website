@extends('backend.layouts.master')

@section('content-header-actions')

<a href="{!! route('admin.events.create') !!}" class="btn btn-block btn-success">
    Create Event <i class="fa fa-fw fa-plus"></i>
</a>

@stop

@section('main-content')

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{!! $event->title !!}</td>
                        <td>{!! $event->present()->eventDate !!}</td>
                        <td>

                            @if ($event->link)
                            <a href="{!! $event->link !!}" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-link"></span> Link
                            </a>
                            @endif
                            <a href="{!! route('admin.events.edit', ['id' => $event->id]) !!}" class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            <a href="{!! route('admin.events.delete', ['id' => $event->id]) !!}" class="btn btn-danger btn-xs">
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