<?php

namespace App\Models;

use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/* TODO: Added a new client by email -- need to update the old one ar add TTL */

class ClientLocation extends Model
{
    use HasFactory;

    /**
     * @var string MongoDB's connection name.
     */
    protected $connection = 'mongodb';

    /**
     * @var string collection name
     */
    protected $collection = DatabaseTableNamesProvider::CLIENT_LOCATION_COLLECTION;

    /**
     * @var array fillable fields
     */
    protected $fillable = [
        'email', 'location',
    ];

    /**
     * Collection name.
     *
     * @return string
     */
    public function collection(): string
    {
        return $this->collection;
    }
}
