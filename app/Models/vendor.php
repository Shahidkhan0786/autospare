<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'location', 'address',
        'cnic', 'cnicexpiry', 'status', 'pic'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}