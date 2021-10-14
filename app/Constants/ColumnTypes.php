<?php

namespace App\Constants;

use Illuminate\Database\Schema\Blueprint;

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
    public const DECIMALS = [self::DECIMAL, self::FLOAT, self::DOUBLE];
    public const BITS = [self::BOOLEAN];
    public const CHARACTERS = [self::CHAR, self::STRING, self::TINY_TEXT, self::TEXT, self::LONG_TEXT];
    public const BLOBS = [self::BLOB, self::LONG_BLOB];
    public const DATES = [self::DATE, self::DATE_TIME, self::TIMESTAMP];

    public const ALL = [
        self::INTEGER, self::TINY_INTEGER, self::SMALL_INTEGER, self::MEDIUM_INTEGER, self::BIG_INTEGER,
        self::DECIMAL, self::FLOAT, self::DOUBLE,
        self::BOOLEAN,
        self::CHAR, self::STRING, self::TINY_TEXT, self::TEXT, self::LONG_TEXT,
        self::BLOB, self::LONG_BLOB,
        self::DATE, self::DATE_TIME, self::TIMESTAMP
    ];

    /**
     * Create the Table Column
     *
     * @param Blueprint $table Schema Blueprint Instance
     * @param string $column_type Column Type
     * @param string $column_name Column Name
     * @return \Illuminate\Database\Schema\ColumnDefinition|null
     */
    public static function createColumnDefinition(Blueprint $table, string $column_type, string $column_name)
    {
        switch ($column_type) {
            case self::INTEGER:
                return $table->integer($column_name);
            case self::TINY_INTEGER:
                return $table->tinyInteger($column_name);
            case self::SMALL_INTEGER:
                return $table->smallInteger($column_name);
            case self::MEDIUM_INTEGER:
                return $table->mediumInteger($column_name);
            case self::BIG_INTEGER:
                return $table->bigInteger($column_name);

            case self::DECIMAL:
                return $table->decimal($column_name);
            case self::FLOAT:
                return $table->float($column_name);
            case self::DOUBLE:
                return $table->double($column_name);

            case self::BOOLEAN:
                return $table->boolean($column_name);

            case self::CHAR:
                return $table->char($column_name);
            case self::STRING:
                return $table->string($column_name);
            case self::TEXT:
                return $table->text($column_name);
            case self::TINY_TEXT:
                return $table->tinyText($column_name);
            case self::LONG_TEXT:
                return $table->longText($column_name);

            case self::BLOB:
            case self::LONG_BLOB:
                return $table->binary($column_name);

            case self::DATE:
                return $table->date($column_name);
            case self::DATE_TIME:
                return $table->dateTime($column_name);
            case self::TIMESTAMP:
                return $table->timestamp($column_name);

            default:
                return null;
        }
    }
}
