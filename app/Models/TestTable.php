<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestTable
 * @package App\Models
 * @property string $name
 * @property integer $columns_count
 * @property-read Collection|TestTableColumn[] $columns
 * @mixin Builder
 */
class TestTable extends Model
{
    protected $fillable = ['name', 'columns_count'];

    protected $casts = ['columns_count' => 'integer'];

    public function columns()
    {
        return $this->hasMany(TestTableColumn::class);
    }
}
