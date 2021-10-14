<?php

namespace App\Constants;

class ColumnTypes
{
    public const INTEGER = 'integer';
    public const TINY_INTEGER = "tiny integer";
    public const SMALL_INTEGER = "small integer";
    public const MEDIUM_INTEGER = "medium integer";
    public const BIG_INTEGER = "big_integer";

    public const DECIMAL = "decimal";
    public const FLOAT = "float";
    public const DOUBLE = "double";
    public const REAL = "real";

    public const BOOLEAN = "boolean";

    public const STRING = "varchar";
    public const CHAR = "char";
    public const TINY_TEXT = "tiny text";
    public const TEXT = "text";
    public const LONG_TEXT = "long text";

    public const BLOB = "blob";
    public const LONG_BLOB = "long blob";

    public const DATE = "date";
    public const DATE_TIME = "date time";
    public const TIMESTAMP = "timestamp";

    public const INTEGERS = [self::INTEGER, self::TINY_INTEGER, self::SMALL_INTEGER, self::MEDIUM_INTEGER, self::BIG_INTEGER];
    public const DECIMALS = [self::DECIMAL, self::FLOAT, self::DOUBLE, self::REAL];
    public const BITS = [self::BOOLEAN];
    public const CHARACTERS = [self::CHAR, self::STRING, self::TINY_TEXT, self::TEXT, self::LONG_TEXT];
    public const BLOBS = [self::BLOB, self::LONG_BLOB];
    public const DATES = [self::DATE, self::DATE_TIME, self::TIMESTAMP];

    public const ALL = [
        self::INTEGER, self::TINY_INTEGER, self::SMALL_INTEGER, self::MEDIUM_INTEGER, self::BIG_INTEGER,
        self::DECIMAL, self::FLOAT, self::DOUBLE, self::REAL,
        self::BOOLEAN,
        self::CHAR, self::STRING, self::TINY_TEXT, self::TEXT, self::LONG_TEXT,
        self::BLOB, self::LONG_BLOB,
        self::DATE, self::DATE_TIME, self::TIMESTAMP
    ];
}
