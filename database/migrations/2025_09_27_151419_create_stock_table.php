<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->string('brand');
            $table->decimal('price');
            $table->string('count');
            $table->string('desc');
            $table->string('stockNumber');
            $table->integer('category_id') ; 
            $table->timestamps();
             
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
