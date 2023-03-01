<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    
    
    
    
    
    
    protected $fillable = [
        'news_id',
        'published_data_time',
        'title',
        'abstract',
        'url',
        'image',
        'is_send',
    ];
}
