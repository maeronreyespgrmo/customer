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
        Schema::create('tbl_cities', function (Blueprint $table) {
            $table->id();
            $table->string("code")->nullable();
            $table->string("name")->nullable();
            $table->string("province_code")->nullable();
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
        Schema::dropIfExists('tbl_cities');
    }
};
