<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestTableColumn
 * @package App\Models
 * @property string $name
 * @property boolean $nullable
 * @property boolean $indexed
 * @property array $extras
 * @property string $column_type
 * @property-read TestTable $table
 * @mixin Builder
 */
class TestTableColumn extends Model
{
    protected $fillable = ['test_table_id', 'name', 'nullable', 'extras', 'column_type', 'indexed'];

    protected $casts = [
        'nullable' => 'boolean',
        'extras' => 'array',
        'indexed' => 'boolean',
    ];

    public function table()
    {
        return $this->belongsTo(TestTable::class);
    }
}
