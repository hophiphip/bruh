<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * User submitted request for insurance offer
 */

class Request extends Model
{
    use HasFactory;

    /**
     * @var string $collection contains collection name
     */
    protected $collection = 'request_collection';


    /**
     *  @var array $fillable contains collection fields names
     */
    protected $fillable = [
        'email',
    ];

}
