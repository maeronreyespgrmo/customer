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
        Schema::create('tbl_form_csm', function (Blueprint $table) {
            $table->id();
            $table->string("office_id")->nullable();
            $table->string("service_id")->nullable();
            $table->string("gender")->nullable();
            $table->string("client_type")->nullable();
            $table->string("comments")->nullable();
            $table->string("age")->nullable();
            $table->string("email")->nullable();
            $table->string("date")->nullable();   
            $table->string("cc1")->nullable();    
            $table->string("cc2")->nullable();    
            $table->string("cc3")->nullable();
            $table->string("sqd0")->nullable(); 
            $table->string("sqd1")->nullable();
            $table->string("sqd2")->nullable();
            $table->string("sqd3")->nullable();
            $table->string("sqd4")->nullable();
            $table->string("sqd5")->nullable();
            $table->string("sqd6")->nullable();
            $table->string("sqd7")->nullable();
            $table->string("sqd8")->nullable();   
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
        Schema::dropIfExists('tbl_form_csm');
    }
};
