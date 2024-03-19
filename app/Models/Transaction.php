<?php

namespace App\Models;

use App\Enums\TransactionStateEnum;
use App\Enums\TransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "payment_id",
        "type",
        "provider",
        "item",
        "bill_amount",
        "fee_amount",
        "total_amount",
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'role' => TransactionStateEnum::class,
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
