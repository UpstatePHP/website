@extends('backend.layouts.master')

@section('main-content')

{!! Form::model($event, ['route' => ['admin.events.update', $event->id]]) !!}

<div class="row">
    <div class="col-lg-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Event Info</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('title') !!}
                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('description') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'data-provide' => 'markdown']) !!}
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Location</h3>
            </div>
            <div class="box-body row">
                <div class="form-group col-lg-6">
                    {!! Form::label('location_name') !!}
                    {!! Form::text('location_name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-6">
                    {!! Form::label('street') !!}
                    {!! Form::text('street', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-6">
                    {!! Form::label('city') !!}
                    {!! Form::text('city', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-3">
                    {!! Form::label('state') !!}
                    {!! Form::states('state', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-3">
                    {!! Form::label('zipcode') !!}
                    {!! Form::text('zipcode', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-6">
                    {!! Form::label('latitude') !!}
                    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-6">
                    {!! Form::label('longitude') !!}
                    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Event Meta</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('begins_at') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        {!! Form::text('begins_at', null, ['class' => 'form-control datetimepicker beginning']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('ends_at') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        {!! Form::text('ends_at', null, ['class' => 'form-control datetimepicker ending']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('registration_link') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                        {!! Form::text('registration_link', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

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