<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveDueDate extends Model
{
    protected $fillable = ['start', 'finish'];
}
