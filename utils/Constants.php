<?php


class Constants
{
    private const API = 'https://rest.websupport.sk';
    private const APIKEY = '0af42f60-58dd-483e-8716-e53d53d0afee';
    private const SECRET = 'cd696e854337b9bdb48fb6e7d7d0e1eb5ddc7f71';

    public static function getApi(): string
    {
        return self::API;
    }

    public static function getApiKey(): string
    {
        return self::APIKEY;
    }

    public static function getSecret(): string
    {
        return self::SECRET;
    }
}