@extends('layouts.main')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="page-header">
                <h1>Videos</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        @foreach ($videos as $video)
            <div class="col-lg-3 video">
                <div class="thumbnail">
                    <img src="{!! $video->thumbnail->url('medium') !!}" title="{!! $video->title !!}" />
                    <div class="caption">
                        {!! $video->published_at->format('F j, Y') !!}
                    </div>
                    <div class="media__body">
                        <h2>{!! $video->title !!}</h2>
                        <p>
                            <a href="https://www.youtube.com/watch?v={!! $video->video_id !!}" target="_blank"><span class="glyphicon glyphicon-play"></span></a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

@stop
