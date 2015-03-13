@extends('layouts.main')

@section('content')

<div id="home-content" class="container">
  <div class="row">
    <div class="col-lg-10 col-lg-offset-1">

        @include('events.next')

    </div>
  </div>
</div>

<div id="home-buckets" class="section-bg-primary">
  <div id="home-content" class="container">
    <div class="row">
	    @include('buckets.recent-video')
        @include('buckets.recent-tweets')
        @include('buckets.supporters')
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-6">
    </div>
    <div class="col-lg-6">
    </div>
  </div>
</div>

@stop

@stop


