@extends('backend.layouts.master')

@section('main-content')

    {!! Form::model($page, ['route' => ['admin.pages.update', $page->id]]) !!}

    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                {!! Form::label('title') !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('path') !!}
                {!! Form::text('path', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                {!! Form::label('content') !!}
                {!! Form::textarea('content', null, ['class' => 'form-control', 'data-provide' => 'markdown']) !!}
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
