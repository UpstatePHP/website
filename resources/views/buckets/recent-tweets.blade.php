<div class="col-lg-4 home-bucket">

    <h3 class="bucket-title">Stay Informed</h3>


    @foreach($tweets as $tweet)

        <div class="tweet media">
            <div class="pull-left">
                <a href="{{ Twitter::linkUser($tweet->user) }}">
                    <img src="{{ $tweet->user->profile_image_url }}" class="media-object"/>
                </a>
            </div>

            <div class="media-body">
                {!! Twitter::linkify($tweet->text) !!}
                <div class="ago">
                    <a href="{{ Twitter::linkTweet($tweet) }}">
                        {{ (new Carbon\Carbon($tweet->created_at))->format('g:ia - j M Y') }}
                    </a>
                </div>
            </div>

        </div>

    @endforeach

</div>

