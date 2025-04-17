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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            //unsignedBigInteger sebuah relasi id dari employee
            $table->unsignedBigInteger('employee_id');
            //unsignedBigInteger sebuah relasi id dari office
            $table->unsignedBigInteger('office_id');
            $table->string('lat_form_employee');
            $table->string('long_form_employee');
            $table->string('lat_from_office');
            $table->string('long_form_office');
            $table->dateTimeTz('attedance_in');
            $table->dateTimeTz('attedance_out');
            $table->tinyInteger('status');
            $table->text('description');
            //nambah relasi
            $table->foreign('employee_id')->on('employees')->references('id')->onDelete('cascade');
            //nambah relasi
            $table->foreign('office_id')->on('offices')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
