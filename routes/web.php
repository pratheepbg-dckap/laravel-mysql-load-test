<?php

use App\Constants\ColumnTypes;
use App\Models\TestTable;
use App\Models\TestTableColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('simple/{table:name}', function (Request $request, TestTable $table) {
    /** @var Collection|TestTableColumn[] $columns */
    $columns = $table->columns()
        ->inRandomOrder()
        ->take((int) $request->input('conditions', 4))
        ->get();

    $query = DB::table($table->name);
    foreach ($columns as $column) {
        $columnType = $column->column_type;
        $columnName = $column->name;

        if (in_array($columnType, ColumnTypes::INTEGERS) || in_array($columnType, ColumnTypes::DECIMALS)) {
            $query->where(
                $columnName,
                ['==', '!=', '<', '>', '<=', '>='][random_int(0, 5)],
                random_int(0, 8000)
            );
        }
        elseif (in_array($columnType, ColumnTypes::CHARACTERS) || in_array($columnType, ColumnTypes::BLOBS)) {
            // No Conditions
        }
        elseif ($columnType == ColumnTypes::BOOLEAN) {
            $query->where($columnName, boolval(random_int(0, 1)));
        }
        else {
            $query->where(
                $columnName,
                ['==', '!=', '<', '>', '<=', '>='][random_int(0, 5)],
                \Faker\Factory::create()->dateTime
            );
        }
    }

    $query->dump();
    $start = microtime(true);
    $query->get();
    $end = microtime(true);

    dump("Duration: " . (($end - $start) * 1000) . "ms" );
});

Route::get('mixed/{table:name}', function (Request $request, TestTable $table) {
    /** @var Collection|TestTableColumn[] $columns */
    $columns = $table->columns()
        ->inRandomOrder()
        ->take((int) $request->input('conditions', 4))
        ->get();

    $query = DB::table($table->name);
    foreach ($columns as $column) {
        $columnType = $column->column_type;
        $columnName = $column->name;
        $constraintMethod = random_int(0, 1) ? 'where' : 'orWhere';

        if (in_array($columnType, ColumnTypes::INTEGERS) || in_array($columnType, ColumnTypes::DECIMALS)) {
            $query->{$constraintMethod}(
                $columnName,
                ['==', '!=', '<', '>', '<=', '>='][random_int(0, 5)],
                random_int(0, 8000)
            );
        }
        elseif (in_array($columnType, ColumnTypes::CHARACTERS) || in_array($columnType, ColumnTypes::BLOBS)) {
            // No Conditions
        }
        elseif ($columnType == ColumnTypes::BOOLEAN) {
            $query->{$constraintMethod}($columnName, boolval(random_int(0, 1)));
        }
        else {
            $query->{$constraintMethod}(
                $columnName,
                ['==', '!=', '<', '>', '<=', '>='][random_int(0, 5)],
                \Faker\Factory::create()->dateTime
            );
        }
    }

    $query->dump();
    $start = microtime(true);
    $query->get();
    $end = microtime(true);

    dump("Duration: " . (($end - $start) * 1000) . "ms" );
});
