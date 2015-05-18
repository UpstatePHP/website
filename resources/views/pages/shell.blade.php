@extends('layouts.main')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="page-header">
                    <h1>{!! $pageHeader !!}</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                {!! $bodyContent !!}
            </div>
        </div>
    </div>

@stop
