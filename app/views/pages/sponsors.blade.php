@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="page-header">
                <h1>Sponsors</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        @foreach ($sponsors as $sponsor)
            <div class="col-lg-3 sponsor">
                <div class="thumbnail">
                    @if ($sponsor->type === 'supporter')
                    <div class="supporter-ribbon">Supporter</div>
                    @endif
                    <img src="/uploads/{{ $sponsor->logo }}">
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

@stop