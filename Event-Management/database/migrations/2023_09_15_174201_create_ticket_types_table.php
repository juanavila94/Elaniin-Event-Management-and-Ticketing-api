<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('quantity');
            $table->float('value', 8, 2);
            $table->string('description');
            $table->date('sale_start_date');
            $table->date('sale_end_date');
            $table->integer('purchase_limit');
            $table->foreignUuid('event_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
