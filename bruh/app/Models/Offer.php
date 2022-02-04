<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * @var string[] $fillable fields to be mass-assigned.
     */
    protected $fillable = ['name', 'company', 'description'];
}
