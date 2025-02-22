<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\NewsHidden;

class News extends Model
{
    protected static function booted()
    {
        static::updated(function ($news) {
            if ($news->isDirty('is_hidden')) 
            {
                event(new NewsHidden('Иван', 'ivan@example.com'));
            }
        });
    }
}