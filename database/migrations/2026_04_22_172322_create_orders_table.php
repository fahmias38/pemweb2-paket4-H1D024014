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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('received_by')->constrained('users');
            $table->date('received_at');
            $table->date('estimated_finish_date');
            $table->decimal('total_weight', 8, 2);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['diterima', 'dicuci', 'dikeringkan', 'disetrika', 'siap_diambil', 'selesai'])->default('diterima');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
