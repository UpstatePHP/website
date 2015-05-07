@extends('backend.layouts.master')

@section('main-content')

{!! Form::model($sponsor, ['route' => ['admin.sponsors.update', $sponsor->id], 'files' => true]) !!}

<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('url') !!}
            {!! Form::text('url', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {!! Form::label('logo') !!}

            @if (! is_null($sponsor->logo))
            <a href="{!! asset('uploads/'.$sponsor->logo) !!}" class="btn btn-default btn-xs pull-right" target="_blank">
                <span class="glyphicon glyphicon-picture"></span> View Logo
            </a>
            @endif
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-paperclip"></i></span>
                {!! Form::file('logo', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('type') !!}
            {!! Form::select('type', $sponsorTypes, null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <button class="btn btn-primary btn-lg" type="submit">
                <span class="glyphicon glyphicon-floppy-disk"></span> Save
            </button>
            &nbsp;
            <a href="{!! URL::previous() !!}" class="btn btn-default btn-lg">Cancel</a>
        </div>
    </div>
</div>

{!! Form::close() !!}

@stop
