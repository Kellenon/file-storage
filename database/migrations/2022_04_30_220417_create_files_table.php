<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', static function (Blueprint $table) {
            $table->uuid()->primary();
            $table->bigInteger('uploader_id')->nullable();
            $table->foreign('uploader_id')->references('id')->on('users')->onDelete('set null');
            $table->string('category')->index();
            $table->string('service')->index();
            $table->string('url');
            $table->string('path');
            $table->json('metadata')->nullable();
            $table->string('description',5000)->nullable();
            $table->boolean('is_temp')->default(false);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE files ALTER COLUMN uuid SET DEFAULT public.uuid_generate_v4();');
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
