@extends('backend.layouts.master')

@section('content-header-actions')

    <a href="{!! route('admin.pages.create') !!}" class="btn btn-block btn-success">
        Create Page <i class="fa fa-fw fa-plus"></i>
    </a>

@stop

@section('main-content')

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Path</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{!! $page->title !!}</td>
                            <td>{!! $page->path !!}</td>
                            <td>
                                <a href="{!! route('admin.pages.edit', ['id' => $page->id]) !!}" class="btn btn-primary btn-xs">
                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                </a>
                                <a href="{!! route('admin.pages.delete', ['id' => $page->id]) !!}" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-remove"></span> Remove
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
