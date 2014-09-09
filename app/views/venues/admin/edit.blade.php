@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-11 col-lg-offset-1">

            <br><br>
        </div>
    </div>
</div>

{{ Form::model($venue, ['route' => ['admin.venues.update', $venue->id], 'method' => 'put']) }}

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                {{ Form::label('name') }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('url') }}
                {{ Form::text('url', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                {{ Form::label('street') }}
                {{ Form::text('street', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('city') }}
                {{ Form::text('city', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('state') }}
                {{ Form::select('state', $states, null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('zip_code') }}
                {{ Form::text('zipcode', null, ['class' => 'form-control']) }}
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