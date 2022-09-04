<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date', 'state_id',
        'num_private_transport', 'price_private_transport',
        'num_taxi_motorbike', 'price_taxi_motorbike',
        'num_private_without_exam', 'price_private_without_exam',
        'num_permissions_data', 'price_permissions_data',
        'num_driving', 'price_driving'];

    public function State()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
