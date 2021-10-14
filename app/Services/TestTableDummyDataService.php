<?php

namespace App\Services;

use App\Constants\ColumnTypes;
use App\Models\TestTable;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class TestTableDummyDataService
{
    /** @var \Faker\Generator */
    private $faker;

    /**
     * TestTableDummyDataService constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function generateDataIntoTable(TestTable $table, int $num_rows)
    {
        $columns = $table->columns;
        for ($i = 1; $i <= $num_rows; $i++) {
            $record = [];

            foreach ($columns as $column) {
                if ($column->nullable && random_int(0, 1)) {
                    $record[$column->name] = null;
                    continue;
                }

                switch ($column->column_type) {
                    case ColumnTypes::INTEGER:
                    case ColumnTypes::TINY_INTEGER:
                    case ColumnTypes::SMALL_INTEGER:
                    case ColumnTypes::MEDIUM_INTEGER:
                    case ColumnTypes::BIG_INTEGER:
                        $record[$column->name] = $this->faker->numberBetween(0, 30000);
                        break;

                    case ColumnTypes::DECIMAL:
                    case ColumnTypes::FLOAT:
                    case ColumnTypes::DOUBLE:
                        $record[$column->name] = $this->faker->randomFloat(4, 0);
                        break;

                    case ColumnTypes::BOOLEAN:
                        $record[$column->name] = $this->faker->boolean;
                        break;

                    case ColumnTypes::STRING:
                    case ColumnTypes::CHAR:
                    case  ColumnTypes::TEXT:
                    case ColumnTypes::TINY_TEXT:
                    case ColumnTypes::LONG_TEXT:
                    case ColumnTypes::BLOB:
                    case ColumnTypes::LONG_BLOB:
                        $record[$column->name] = $this->faker->sentence(10);
                        break;

                    case ColumnTypes::DATE:
                    case ColumnTypes::DATE_TIME:
                    case ColumnTypes::TIMESTAMP:
                        $record[$column->name] = $this->faker->dateTime;
                        break;
                }
            }

            DB::table($table->name)
                ->insert($record);
        }

        return true;
    }
}
