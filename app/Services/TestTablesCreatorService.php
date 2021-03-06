<?php

namespace App\Services;

use App\Constants\ColumnTypes;
use App\Models\TestTable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TestTablesCreatorService
{
    /**
     * Create a test Table for the performance test
     *
     * @param string $table_name
     * @param int $columns
     * @param array|null $column_types
     * @param int $maximum_indexes
     * @param bool $silent Doesn't enter the Table Schema into tracking tables
     * @return TestTable|bool
     * @throws \Exception
     */
    public function createTestTable(string $table_name, int $columns, ?array $column_types = null, int $maximum_indexes = 0, bool $silent = false)
    {
        if (! $silent) {
        /** @var TestTable $testTable */
        $testTable = TestTable::query()
            ->create([
                'name' => $table_name,
                'columns_count' => $columns
            ]);
        }
        else {
            $testTable = null;
        }
        $column_types ??= ColumnTypes::ALL;

        try {
            Schema::create($table_name, function (Blueprint $table) use ($table_name, $columns, $column_types, $maximum_indexes, $testTable, $silent) {
                $indexesAdded = 0;
                $columnsCreated = collect([]);

                for ($i = 1; $i <= $columns; $i++) {
                    $column_name = "col_$i";
                    $column_type = Arr::random($column_types, 1)[0];
                    $nullable = boolval(random_int(0, 1));
                    $index = false;
                    if ($indexesAdded < $maximum_indexes && $this->canColumnTypeBeIndexed($column_type)) {
                        $index = random_int(1, 30) == 1;

                        if ($index)
                            $indexesAdded++;
                    }

                    $columnDefinition = ColumnTypes::createColumnDefinition($table, $column_type, $column_name);
                    if ($nullable)
                        $columnDefinition->nullable();
                    if ($index)
                        $columnDefinition->index();

                    $column_information = [
                        'name' => $column_name,
                        'column_type' => $column_type,
                        'nullable' => $nullable,
                        'indexed' => $index
                    ];

                    $columnsCreated->push($column_information);
                    if (! $silent)
                        $testTable->columns()->create($column_information);
                }
                Log::info("Trying to create Table {$table_name}", $silent ? [] : $columnsCreated->groupBy('column_type')->map->count()->toArray());
            });
            Log::info("Successfully created Table {$table_name}");
        } catch (\Exception $exception) {
            Log::warning("Failed to create Table {$table_name}");

            if (! $silent)
                $testTable->delete();

            throw $exception;
        }

        return $testTable ?? true;
    }

    /**
     * Whether the Column Type can be indexed
     *
     * @param string $column_type
     * @return bool
     */
    private function canColumnTypeBeIndexed(string $column_type): bool
    {
        return ! in_array($column_type, [ColumnTypes::TINY_TEXT, ColumnTypes::TEXT, ColumnTypes::LONG_TEXT, ColumnTypes::BLOB, ColumnTypes::LONG_BLOB]);
    }
}
