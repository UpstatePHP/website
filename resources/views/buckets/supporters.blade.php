<div class="col-lg-4 home-bucket">

    <h3 class="bucket-title">Supporters & Sponsors</h3>

    <div class="row">

        @foreach($supporters as $supporter)

        <div class="supporter col-lg-6">
            <a href="{{ $supporter->url }}" title="{{ $supporter->name }}" target="_blan
k" class="thumbnail">
                <img src="{{ '/uploads/'.$supporter->logo }}" />
            </a>
        </div>

        @endforeach

    </div>

</div>

