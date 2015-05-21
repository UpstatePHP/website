@extends('backend.layouts.master')

@section('content-header-actions')

    <button
            id="import-videos"
            type="button"
            class="btn btn-block btn-default"
            data-loading-text="Importing <i class='fa fa-refresh fa-spin'></i>"
            data-import-url="{!! route('admin.videos.import') !!}"
    >
        Import Videos <i class="fa fa-fw fa-download"></i>
    </button>

@stop

@section('main-content')
    
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Video ID</th>
                    <th>Published On</th>
                    <th>Imported On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($videos as $video)
                <tr>
                    <td>{!! $video->title !!}</td>
                    <td>{!! $video->video_id !!}</td>
                    <td>{!! $video->published_at->format('m/d/Y') !!}</td>
                    <td>{!! $video->imported_at->format('m/d/Y') !!}</td>
                    <td>
                        <a href="{!! route('admin.videos.edit', ['id' => $video->id]) !!}" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="{!! route('admin.videos.delete', ['id' => $video->id]) !!}" class="btn btn-danger btn-xs">
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
