<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory, Searchable;

    /**
     * @var string database table name
     */
    protected $table = 'offers';

    /**
     * @var string[] $fillable fields to be mass-assigned.
     */
    protected $fillable = ['name', 'company', 'description'];
}
