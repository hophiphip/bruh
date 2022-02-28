<?php

namespace App\Models\Mongo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ClientLocation extends Model
{
    use HasFactory;

    /**
     * @var string collection name
     */
    protected $collection = 'client_location_collection';

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

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
