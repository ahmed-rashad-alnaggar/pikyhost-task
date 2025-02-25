<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'title',
        'slug',
        'seo_keywords',
        'seo_description',
    ];

    public function sections() : HasMany
    {
        return $this->hasMany(PageSection::class);
    }
}
