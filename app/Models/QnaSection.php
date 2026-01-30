<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QnaSection extends Model
{
    protected $fillable = [
        'question',
        'answer',
    ];
}
