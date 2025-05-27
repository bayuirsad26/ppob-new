<?php

use App\Enums\TransactionStateEnum;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id');
            $table->string('payment_id')->nullable();
            $table->string('type')->nullable();
            $table->string('provider')->nullable();
            $table->string('item')->nullable();
            $table->float('bill_amount')->nullable();
            $table->float('fee_amount')->nullable();
            $table->float('total_amount')->nullable();
            $table->enum('status', [
                TransactionStateEnum::PENDING->value,
                TransactionStateEnum::FAILED->value,
                TransactionStateEnum::COMPLETED->value,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
