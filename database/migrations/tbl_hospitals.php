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
        //
        Schema::create('tbl_hospitals', function (Blueprint $table) {
            $table->id();
            $table->string("hospital_name")->nullable();
            $table->string("hospital_address")->nullable();
            $table->string("hospital_number")->nullable();
            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tbl_hospitals');
    }
};
