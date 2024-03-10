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
        Schema::create('tbl_form_css', function (Blueprint $table) {
            $table->id();
            $table->string("name_evaluatee")->nullable();
            $table->string("name_evaluator")->nullable();
            $table->string("date")->nullable();
            $table->string("office_id")->nullable();
            $table->string("services_id")->nullable();
            $table->string("radio_1")->nullable();
            $table->string("radio_2")->nullable();
            $table->string("radio_3")->nullable();
            $table->string("radio_4")->nullable();
            $table->string("radio_5")->nullable();
            $table->string("radio_6")->nullable();
            $table->string("radio_7")->nullable();
            $table->string("radio_8")->nullable();
            $table->string("radio_9")->nullable();
            $table->string("radio_10")->nullable();
            $table->string("radio_11")->nullable();
            $table->string("radio_12")->nullable();
            $table->string("comments")->nullable();
            $table->string("comments_status")->nullable();
            $table->text("others_remarks")->nullable();
            $table->string("invalidated")->nullable();
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
        Schema::dropIfExists('tbl_form_css');
    }
};
