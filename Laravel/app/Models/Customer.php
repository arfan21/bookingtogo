<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";
    protected $primaryKey = "cst_id";

    protected $fillable = [
        "cst_name", "cst_dob", "cst_phoneNum", "cst_email", "national_id"
    ];

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'national_id', 'national_id');
    }

    public function familyList()
    {
        return $this->hasMany(FamilyList::class, 'cst_id', 'cst_id');
    }
}
