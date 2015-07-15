@extends('layouts.main')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-content hero">
                    <div class="page-header">
                        <h1>Sponsors</h1>
                    </div>
                    @foreach ($sponsors as $sponsor)
                        <div class="col-lg-3 sponsor">
                            <div class="thumbnail">
                                @if ($sponsor->type === 'supporter')
                                <div class="supporter-ribbon">Supporter</div>
                                @endif
                                <a href="{!! $sponsor->url !!}" target="_blank">
                                    <img src="/uploads/{!! $sponsor->logo !!}" title="{!! $sponsor->name !!}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@stop
