<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('title');
            $table->string('company_name');
            $table->string('place');
            $table->string('salary');
            $table->text('salary_detail');
            $table->string('hours');
            $table->text('hours_detail');
            $table->text('features')->nullable();
            $table->text('detail');
            $table->text('treatment');
            $table->text('qualification');
            $table->string('location');
            $table->string('file')->nullable();
            $table->integer('status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
