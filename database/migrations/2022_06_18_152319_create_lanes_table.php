<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lanes', function (Blueprint $table) {
            $table->id();
            $table->string('title') ;
            $table->text('description')->nullable() ;
            $table->integer('index') ;
            $table->foreignId('board_id')->constrained()->onDelete('cascade') ;
            $table->foreignId('author_id')->constrained('users') ;
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
        Schema::dropIfExists('lanes');
    }
};
