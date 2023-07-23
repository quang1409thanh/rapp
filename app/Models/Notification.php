<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $incrementing = true;
    public function notifiable()
    {
        return $this->morphTo();
    }

}
