<?php

namespace App\Console\Commands;

use App\Models\TestTable;
use App\Services\TestTableDummyDataService;
use Illuminate\Console\Command;

class InsertDummyDataIntoTestTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Populate Dummy Data into the test Table";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table_name = $this->choice(
            "Select the Table to populate Dummy data.",
            TestTable::query()->pluck('name')->toArray()
        );
        /** @var TestTable $table */
        $table = TestTable::query()->where('name', $table_name)->firstOrFail();

        while (true) {
            $rows = $this->ask("Enter the Number of Rows to be added to the Table");

            if (is_numeric($rows)) {
                $rows = intval($rows);
                break;
            }
            else {
                $this->warn("Please enter a Valid Numerical Value");
            }
        }

        $start = microtime(true);
        $result = app(TestTableDummyDataService::class)->generateDataIntoTable($table, $rows);
        $end = microtime(true);

        $this->line("Time Elapsed: ". (($end - $start) / 1000 / 1000) . 's');

        if ($result) {
            $this->info("Table was successfully populated with the Dummy Data");
        } else {
            $this->error("Failed to Insert the Data into the Table");
        }

        return Command::SUCCESS;
    }
}
