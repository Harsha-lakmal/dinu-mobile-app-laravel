<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('categoriesNumber')->unique();
            $table->integer('sub_categoires_id');
            $table->string('decs');
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
