<?php
namespace UpstatePHP\Website\Domain\Pages;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'path', 'content'];

    public static function findByPath($path)
    {
        return static::query()->where('path', $path)->first();
    }
}
