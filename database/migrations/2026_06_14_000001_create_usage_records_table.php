<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usage_records', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->string('meter');
            $table->unsignedInteger('quantity')->default(0);
            $table->date('period_start');
            $table->timestamps();

            $table->unique(['tenant_id', 'meter', 'period_start']);
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_records');
    }
};
