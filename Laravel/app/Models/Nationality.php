<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $table = "nationality";
    protected $primaryKey = "national_id";

    protected $fillable = [
        'national_name',
        'national_code',
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class, 'national_id', 'national_id');
    }
}
