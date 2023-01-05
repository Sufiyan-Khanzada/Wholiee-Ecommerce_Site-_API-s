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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('Product_name')->nullable();
            $table->string('Product_Category')->nullable();
            $table->string('Product_Description')->nullable();
            $table->string('Product_Per_Price')->nullable();
            $table->string('Product_Image')->nullable();            
            $table->string('Product_Available_Qty')->nullable();
            $table->string('Product_status')->nullable();
            $table->string('user_id')->nullable();


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
        Schema::dropIfExists('products');
    }
};
