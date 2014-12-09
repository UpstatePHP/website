@if(! is_null($nextEvent))
<div class="event">
    <div class="event-details">
        <div class="col-lg-8">
            <div class="event-title page-header">
                <h1>{{ $nextEvent->title or 'Next Event' }}</h1>
            </div>
            <div class="event-body">
                <div class="event-datetime">
                   {{ $nextEvent->startDate . '<br>' . $nextEvent->startTime }}
                </div>
                <div class="event-meta-line">
                    {{ $nextEvent->description }}
                </div>
<!--                <div class="event-meta-line">-->
<!--                    <div class="meta-line-title">speakers:</div>-->
<!--                    <div>Benjamin Young, Barry Jones</div>-->
<!--                </div>-->
<!--                <div class="event-meta-line">-->
<!--                    <div class="meta-line-title">sponsor:</div>-->
<!--                    <div>OpenWorks, MoonClerk, Laracasts, PhpStorm</div>-->
<!--                </div>-->
            </div>
            <div class="event-actions">
<!--                <a href="--><?php ////echo $permalink; ?><!--" target="_blank">-->
<!--                    <button type="button" class="btn btn-primary btn-lg">Learn More</button>-->
<!--                </a>-->
                <a href="{{ $nextEvent->registration_link }}?ref=ebtnebregn" target="_blank">
                    <button type="button" class="btn btn-primary btn-lg pull-right">Register Now &raquo;</button>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="thumbnail map-thumbnail">
                <div id="event-location-map"></div>
                <div id="event-location-info" data-location='{{ $nextEvent->eventLocation }}'>
                    <h4>{{ $nextEvent->location_name }}</h4>
                </div>
            </div>

        </div>
    </div>
</div>
@else
<div class="event">
    <div class="event-details">
        <div class="col-lg-8">
            <div class="event-title page-header">
                <h1>Next Event &mdash; Stay Tuned!</h1>
            </div>
        </div>
    </div>
</div>
@endif