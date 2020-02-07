<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservedInfo extends Model
{
    protected $fillable = [
      'id',
      'name',
      'reserved_date',
      'reserved_time',
      'price',
      'mail_address'
    ];
}
