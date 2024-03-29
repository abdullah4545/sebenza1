<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casemanagement extends Model
{
    use HasFactory;

    public function getCustomer_e_signatureAttribute($value)
    {
       if($value==''){
        return $value;
       }else{
        return env('PROD_URL').$value;
       }
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function assigns()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
