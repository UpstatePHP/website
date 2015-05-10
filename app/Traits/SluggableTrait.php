<?php namespace UpstatePHP\Website\Traits;

use Illuminate\Support\Str;

trait SluggableTrait {

    public function makeSlug($value)
    {
        return substr(Str::slug($value), 0, 60);
    }

    public function makeSlugFromDatabase($value)
    {
        $slug = $this->makeSlug($value);

        $query = $this->newQuery();
        $query->where('slug', 'LIKE', "{$slug}%");

        if ($count = $query->count()) {
            return $this->makeSlug($value.'-'.($count + 1));
        }

        return $slug;
    }

}