@extends('backend.layouts.master')

@section('content-header-actions')

    <a href="{!! route('admin.sponsors.create') !!}" class="btn btn-block btn-success">
        Create Sponsor <i class="fa fa-fw fa-plus"></i>
    </a>

@stop

@section('main-content')
    
<div class="row">
    <div class="col-lg-12">
        <div class="box">
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
                    <td>{!! $sponsor->name !!}</td>
                    <td><a href="{!! $sponsor->url !!}">{!! $sponsor->url !!}</a></td>
                    <td>{!! ucwords(str_replace('-', ' ', $sponsor->type)) !!}</td>
                    <td>
                        @if (! is_null($sponsor->logo))
                        <a href="{!! asset('uploads/'.$sponsor->logo) !!}" class="btn btn-default btn-xs" target="_blank">
                            <span class="glyphicon glyphicon-picture"></span> View Logo
                        </a>
                        @endif
                    </td>
                    <td>
                        <a href="{!! route('admin.sponsors.edit', ['id' => $sponsor->id]) !!}" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="{!! route('admin.sponsors.delete', ['id' => $sponsor->id]) !!}" class="btn btn-danger btn-xs">
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
