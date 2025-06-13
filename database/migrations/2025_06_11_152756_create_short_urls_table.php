<?php

// database/migrations/xxxx_xx_xx_create_short_urls_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade'); // 🔹 optional
            $table->string('original_url');
            $table->string('short_code')->unique();
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('short_urls');
    }
};

