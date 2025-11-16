<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('nik')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->enum('position', ['staff', 'admin', 'supervisor', 'manager', 'intern']);
            $table->enum('division', ['hrd', 'finance', 'IT', 'marketing', 'operation', 'GA']);
            $table->date('joined_at');

            $table->string('telp_number')->nullable();
            $table->date('birth_day')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['aktif', 'non-aktif', 'resign', 'cuti'])->nullable();
            $table->integer('salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
