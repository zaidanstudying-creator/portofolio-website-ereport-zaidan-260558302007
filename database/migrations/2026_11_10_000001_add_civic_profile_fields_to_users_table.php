<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('no_whatsapp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->string('role')->default('warga')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['role']);
            $table->dropColumn(['no_whatsapp', 'alamat', 'foto', 'role']);
        });
    }
};
