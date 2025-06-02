<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('files')->onDelete('cascade');
            $table->string('name');
            $table->string('path')->unique();
            $table->string('type')->default('file'); // 'file' or 'folder'
            $table->boolean('is_folder')->default(false);
            $table->string('mime_type')->nullable();
            $table->bigInteger('size')->default(0); // in bytes
            $table->string('extension')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better performance
            $table->index('user_id');
            $table->index('parent_id');
            $table->index('is_folder');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}; 