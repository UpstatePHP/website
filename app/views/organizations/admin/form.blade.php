@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-11 col-lg-offset-1">

            <br><br>
        </div>
    </div>
</div>

{{ Form::model($organization, ['route' => ['admin.organizations.update', $organization->id], 'files' => true]) }}

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
                {{ Form::label('logo') }}

                @if (! is_null($organization->logo))
                <a href="{{ asset('images/'.$organization->logo) }}" class="btn btn-default btn-xs pull-right" target="_blank">
                    <span class="glyphicon glyphicon-picture"></span> View Logo
                </a>
                @endif

                {{ Form::file('logo') }}
            </div>
            <div class="form-group">
                {{ Form::label('type') }}
                {{ Form::select('type', $organizationTypes, null, ['class' => 'form-control']) }}
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