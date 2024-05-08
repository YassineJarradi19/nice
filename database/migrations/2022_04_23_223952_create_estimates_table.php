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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->string('estimate_number');
            $table->string('type_demande');
            $table->string('estimate_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->text('other_information')->nullable();
            $table->unsignedBigInteger('user_id');  // Add user_id column
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade');  // Automatically deletes estimates when the associated user is deleted

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
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropForeign(['user_id']);  // Drop the foreign key constraint
        });

        Schema::dropIfExists('estimates');  // Correctly use dropIfExists to drop the table
    }
};
