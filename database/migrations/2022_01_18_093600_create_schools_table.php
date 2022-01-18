<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schools', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('address')->unique();
      $table->string('status');
      $table->string('lat', 24)->unique();
      $table->string('lang', 24)->unique();
      $table->string('logo_photo_path', 1024)->nullable();
      $table->foreignId('school_level_id')->constrained();
      $table->foreignId('village_id')->constrained();
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
    Schema::dropIfExists('schools');
  }
}
