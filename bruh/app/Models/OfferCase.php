<?php

namespace App\Models;

use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferCase extends Model
{
    use HasFactory;

    /**
     * @var string $table user table name
     */
    protected $table = DatabaseTableNamesProvider::OFFER_CASE_TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color',
    ];
}
