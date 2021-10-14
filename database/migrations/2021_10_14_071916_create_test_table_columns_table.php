<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTableColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_table_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_table_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('column_type');
            $table->boolean('nullable')->default(false);
            $table->boolean('indexed')->default(false);
            $table->text("extras")->default("{}");
            $table->index(['test_table_id', 'name']);
            $table->index(['test_table_id', 'column_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_table_columns');
    }
}
