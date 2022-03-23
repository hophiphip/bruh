<?php

namespace App\Models;

use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Stevebauman\Location\Position;

/* TODO: Database must store email hash */

class ClientLocation extends Model
{
    use HasFactory;

    /**
     * @var string MongoDB's connection name.
     */
    protected $connection = DatabaseTableNamesProvider::CLIENT_LOCATION_COLLECTION_CONNECTION;

    /**
     * Overwriting default constructor to set database connection dynamically.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = DatabaseTableNamesProvider::client_location_collection_connection();
    }

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


    /**
     * Create a new client location info from email and position.
     *
     * @param string $email
     * @param Position $position
     * @return mixed
     */
    public static function createNew(string $email, Position $position): mixed
    {
        /* TODO: Can be seed up with local DB location storage -- but need to download some stuff and store it in .git repo and licence stuff */

        return ClientLocation::create([
            'email'    => $email,
            'location' => [
                'country_code' => $position->countryCode,
                'country'      => $position->countryName,
                'city'         => $position->cityName,
                'lat'          => $position->latitude,
                'lng'          => $position->longitude
            ],
        ]);
    }
}
