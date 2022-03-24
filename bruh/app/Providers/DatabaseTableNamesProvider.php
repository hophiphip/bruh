<?php

namespace App\Providers;

class DatabaseTableNamesProvider
{
    public const CLIENT_LOCATION_COLLECTION = 'client_location_collection';
    public const CLIENT_LOCATION_COLLECTION_CONNECTION = 'mongodb';

    public static function client_location_collection_connection(): string
    {
        return env('MONGO_DB_CONNECTION', self::CLIENT_LOCATION_COLLECTION_CONNECTION);
    }

    public const INSURER_TABLE = 'insurers';
    public const LOGIN_TOKEN_TABLE = 'login_tokens';
    public const OFFER_TABLE = 'offers';
    public const OFFER_REQUEST_TABLE = 'offer_requests';
    public const ROLE_TABLE = 'roles';
    public const USER_TABLE = 'users';
    public const OFFER_CASE_TABLE = 'offer_cases';

    public const ROLE_TO_USER_TABLE = 'role_user';
}
