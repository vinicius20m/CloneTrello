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
        Schema::create('board_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade') ;
            $table->foreignId('board_id')->constrained()->onDelete('cascade') ;
            $table->boolean('is_owner')->default(false) ;
            $table->boolean('accepted')->default(false) ;
            $table->boolean('can_create')->default(false) ;
            $table->boolean('can_edit')->default(false) ;
            $table->boolean('can_delete')->default(false) ;
            $table->boolean('can_move')->default(false) ;
            $table->boolean('can_add_member')->default(false) ;
            $table->boolean('can_remove_member')->default(false) ;
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
        Schema::dropIfExists('board_permissions');
    }
};
