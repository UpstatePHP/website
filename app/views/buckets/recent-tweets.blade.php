<div class="col-lg-4 home-bucket">

    <h3 class="bucket-title">Recent Tweets</h3>

    @foreach($tweets as $tweet)

    <div class="tweet">
        {{ Twitter::linkify($tweet->text) }}
        <span class="ago">
            - <a href="{{ Twitter::linkTweet($tweet) }}">{{ Twitter::ago($tweet->created_at) }}</a>
        </span>
    </div>

    @endforeach

</div>