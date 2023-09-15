<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyList extends Model
{
    use HasFactory;

    protected $table = "family_list";
    protected $primaryKey = "fl_id";

    protected $fillable = [
        'cst_id',
        'fl_relation',
        'fl_name',
        'fl_dob',
    ];
}
