<?php

namespace NormanHuth\Library\Support;

class Hash
{
    /**
     * Generate a hash value (message digest).
     */
    protected static function hash(string $algo, string|int|float $data, bool $binary, array $options): string
    {
        return hash($algo, (string) $data, $binary, $options);
    }

    /**
     * Generate a gost hash value (message digest).
     */
    public static function gost(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('gost', $data, $binary, $options);
    }

    /**
     * Generate a gost-crypto hash value (message digest).
     */
    public static function gostCrypto(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('gost-crypto', $data, $binary, $options);
    }

    /**
     * Generate a joaat hash value (message digest).
     */
    public static function joaat(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('joaat', $data, $binary, $options);
    }

    /**
     * Generate a md5 hash value (message digest).
     */
    public static function md5(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('md5', $data, $binary, $options);
    }

    /**
     * Generate a sha1 hash value (message digest).
     */
    public static function sha1(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('sha1', $data, $binary, $options);
    }

    /**
     * Generate a sha256 hash value (message digest).
     */
    public static function sha256(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('sha256', $data, $binary, $options);
    }

    /**
     * Generate a sha384 hash value (message digest).
     */
    public static function sha384(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('sha384', $data, $binary, $options);
    }

    /**
     * Generate a sha512 hash value (message digest).
     */
    public static function sha512(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('sha384', $data, $binary, $options);
    }

    /**
     * Generate a snefru hash value (message digest).
     */
    public static function whirlpool(string|int|float $data, bool $binary = false, array $options = []): string
    {
        return self::hash('whirlpool', $data, $binary, $options);
    }
}
