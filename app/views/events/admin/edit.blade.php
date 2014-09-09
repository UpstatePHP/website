@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-11 col-lg-offset-1">

            <br><br>
        </div>
    </div>
</div>

{{ Form::model($event, ['route' => ['admin.events.update', $event->id], 'method' => 'put']) }}

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                {{ Form::label('title') }}
                {{ Form::text('title', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('description') }}
                {{ Form::textarea('description', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                {{ Form::label('venue') }}
                {{ Form::select('venue_id', $venues, null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('begins_at') }}
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    {{ Form::text('begins_at', null, ['class' => 'form-control datetimepicker beginning']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('ends_at') }}
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    {{ Form::text('ends_at', null, ['class' => 'form-control datetimepicker ending']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('registration_link') }}
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                    {{ Form::text('registration_link', null, ['class' => 'form-control']) }}
                </div>
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
                <a href="{{ URL::previous() }}" class="btn btn-default btn-lg">Cancel</a>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}

@stop