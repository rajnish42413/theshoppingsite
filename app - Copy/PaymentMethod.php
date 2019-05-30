<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = "paymentmethods";
    
    protected $fillable = [
        'id','name','description','status','created_at','updated_at'
    ];
}
