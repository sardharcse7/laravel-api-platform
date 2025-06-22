<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('billing_month'); // Format: YYYY-MM (e.g., 2025-06)
            $table->integer('included_calls')->default(10000);
            $table->integer('extra_calls')->default(0);
            $table->decimal('amount_charged', 8, 2)->default(0.00);
            $table->timestamps();

            $table->unique(['user_id', 'billing_month']); // Prevent duplicates
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_records');
    }
}
