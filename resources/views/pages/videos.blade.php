@extends('layouts.main')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-deck-wrapper">
                <div class="card-deck card-columns">

                    @foreach ($videos as $video)
                        <div class="col-lg-4 video card">
                            <div>
                                <img class="card-img-top" src="{!! $video->thumbnail->url('medium') !!}" title="{!! $video->title !!}" />
                                <div class="card-block">
                                    <p>
                                        <h4>{!! $video->title !!}</h4>
                                    </p>
                                    <p>{!! $video->published_at->format('F j, Y') !!}</p>
                                </div>
                                <div class="media__body">
                                    <a href="https://www.youtube.com/watch?v={!! $video->video_id !!}" target="_blank">
                                        <span class="play-circle">
                                            <span class="glyphicon glyphicon-play"></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@stop
