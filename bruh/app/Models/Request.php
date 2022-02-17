<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    /**
     * @var string database table name
     */
    protected $table = 'requests';


    /**
     *  @var array $fillable contains collection fields names
     */
    protected $fillable = [
        'email',
    ];
}
