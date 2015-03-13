<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model {

  protected $fillable = ['type', 'url', 'logo', 'name'] ;
  
}
