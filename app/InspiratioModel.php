<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspiratioModel extends Model
{
    protected $table = 'iposts';
    protected $fillable=[
        'name',
        'path',
        'original_name',
    ];
}
