<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('files', static function (Blueprint $table) {
            $table->dateTime('available_until')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::dropColumns('files', ['available_until']);
    }
};
