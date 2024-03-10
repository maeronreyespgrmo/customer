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
        Schema::create('tbl_form_pss', function (Blueprint $table) {
            $table->id();
            $table->string("patient_name")->nullable();
            $table->string("home_address")->nullable();
            $table->string("hospital_id")->nullable();
            $table->string("date")->nullable();
            $table->string("date_in")->nullable();
            $table->string("date_out")->nullable();
            $table->string("checked_doctor")->nullable();
            $table->string("before_admit")->nullable();
            $table->text("radio1_a")->nullable();
            $table->text("radio1_b")->nullable();
            $table->text("radio1_c")->nullable();
            $table->text("radio1_d")->nullable();
            $table->text("radio1_e")->nullable();
            $table->text("radio1_f")->nullable();
            $table->text("radio1_g")->nullable();
            $table->text("radio2_a")->nullable();
            $table->text("radio2_b")->nullable();
            $table->text("radio2_c")->nullable();
            $table->text("radio2_d")->nullable();
            $table->text("radio2_e")->nullable();
            $table->text("radio3_a")->nullable();
            $table->text("radio3_b")->nullable();
            $table->text("radio3_c")->nullable();
            $table->text("radio3_d")->nullable();
            $table->text("radio3_e")->nullable();
            $table->text("radio4_a")->nullable();
            $table->text("radio4_b")->nullable();
            $table->text("radio4_c")->nullable();
            $table->text("radio4_d")->nullable();
            $table->text("radio5_a")->nullable();
            $table->text("radio5_b")->nullable();
            $table->text("radio5_c")->nullable();
            $table->text("radio5_d")->nullable();
            $table->text("radio5_e")->nullable();
            $table->text("radio6_a")->nullable();
            $table->text("radio6_b")->nullable();
            $table->text("radio6_c")->nullable();
            $table->text("radio6_d")->nullable();
            $table->text("radio6_e")->nullable();
            $table->text("radio7_a")->nullable();
            $table->text("radio7_b")->nullable();
            $table->text("radio7_c")->nullable();
            $table->text("radio7_d")->nullable();
            $table->text("radio7_e")->nullable();
            $table->text("radio8_a")->nullable();
            $table->text("radio8_b")->nullable();
            $table->text("radio8_c")->nullable();
            $table->text("radio8_d")->nullable();
            $table->text("radio8_e")->nullable();
            $table->text("radio9_a")->nullable();
            $table->text("radio9_b")->nullable();
            $table->text("radio9_c")->nullable();
            $table->text("radio9_d")->nullable();
            $table->text("radio9_e")->nullable();
            $table->text("radio10_a")->nullable();
            $table->text("radio10_b")->nullable();
            $table->text("radio10_c")->nullable();
            $table->text("radio10_d")->nullable();
            $table->text("radio10_e")->nullable();
            $table->text("radio11_a")->nullable();
            $table->text("radio11_b")->nullable();
            $table->text("radio11_c")->nullable();
            $table->text("radio11_d")->nullable();
            $table->text("radio12_a")->nullable();
            $table->text("radio12_b")->nullable();
            $table->text("radio12_c")->nullable();
            $table->text("radio12_d")->nullable();
            $table->text("radio12_e")->nullable();
            $table->text("radio13_a")->nullable();
            $table->text("radio13_b")->nullable();
            $table->text("radio13_c")->nullable();
            $table->text("radio13_d")->nullable();
            $table->text("radio13_e")->nullable();
            $table->text("radio14_a")->nullable();
            $table->text("radio14_b")->nullable();
            $table->text("radio14_c")->nullable();
            $table->text("radio14_d")->nullable();
            $table->text("radio14_e")->nullable();
            $table->text("comments")->nullable();
            $table->string("comments_status")->nullable();
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
        Schema::dropIfExists('tbl_form_pss');
    }
};
