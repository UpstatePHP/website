@section('body')

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            {{ Form::open(['route' => 'login.post']) }}
            <div class="form-group">
                {{ Form::label('email') }}
                {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('password') }}
                {{ Form::password('password', ['class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::button('Login', ['class' => 'btn btn-primary pull-right', 'type' => 'submit']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@stop