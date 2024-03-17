<?php

//database/migrations/2023_04_28_092026_create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->binary('image')->nullable(); // Tambahkan kolom untuk gambar
            $table->string('address')->nullable(); // Tambahkan kolom untuk alamat
            $table->date('date')->nullable(); // Tambahkan kolom untuk tanggal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
