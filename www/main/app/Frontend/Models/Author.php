<?php

namespace App\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function getCount()
    {
        return $this->count();
    }
}