<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary', 300);           // one-liner for cards
            $table->longText('description')->nullable(); // markdown case study
            $table->string('role')->nullable();       // e.g. "Solo developer"
            $table->string('year', 20)->nullable();   // e.g. "2026"
            $table->json('tech_stack')->nullable();   // ["ASP.NET Core", "SQL Server"]
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();      // extra screenshots
            $table->string('repo_url')->nullable();
            $table->string('live_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
