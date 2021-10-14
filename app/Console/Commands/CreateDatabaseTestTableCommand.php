<?php

namespace App\Console\Commands;

use App\Constants\ColumnTypes;
use App\Services\TestTablesCreatorService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateDatabaseTestTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Database Table for testing.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table_name = $this->ask("Enter the Table Name");

        while (true) {
            $columns = $this->ask("Enter the Number of Columns to be added to the Table");

            if (is_numeric($columns)) {
                $columns = intval($columns);
                break;
            }
            else {
                $this->warn("Please enter a Valid Numerical Value");
            }
        }

        $column_types_choices = $this->choice(
            "Please Select the Column Types to be included in the table (Comma separated Values)",
            array_map(fn($type) => ucwords($type), ColumnTypes::ALL),
            0,
            3,
            true
        );
        $column_types = array_map('strtolower', $column_types_choices);

        while (true) {
            $index = $this->ask("Enter the maximum Number of Columns to be Indexed", "0");

            if (is_numeric($index)) {
                $index = intval($index);
                break;
            }
            else {
                $this->warn("Please enter a Valid Numerical Value");
            }
        }

        try {
            $table = app(TestTablesCreatorService::class)->createTestTable(
                $table_name,
                $columns,
                $column_types ?: null,
                $index
            );

            $this->info("Table \"{$table->name}\" was successfully created");
            $this->table(
                ["Column Type", "Number of Columns"],
                $table->columns
                    ->groupBy('column_type')
                    ->map->count()
                    ->map(fn($count, $type) => [ucwords($type), $count])
                    ->toArray()
            );

        } catch (\Exception $e) {
            $this->error("Failed to create the Database Table");
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }

        return Command::SUCCESS;
    }
}
