@section('body')

<div id="home-content" class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            @include('events.next')
        </div>
    </div>
</div>

<div class="section-bg-primary">
    <div class="container">
        <div class="row">
            @include('buckets.recent-video')

            @include('buckets.recent-tweets')

            @include('buckets.supporters')
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

    </div>
</div>

@stop