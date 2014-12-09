<?php

Form::macro('states', function($name, $selected, $attributes)
{
    return Form::select($name, Config::get('states'), $selected, $attributes);
});