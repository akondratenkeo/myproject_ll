<?php

namespace App\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function getCount()
    {
        return $this->count();
    }
}