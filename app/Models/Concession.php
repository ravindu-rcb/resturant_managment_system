<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    protected $fillable = ['name','description','image_path','price'];
}
