<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('featured_alt')->nullable()->after('canonical_url');
            $table->string('featured_credit')->nullable()->after('featured_alt');
            $table->text('featured_caption')->nullable()->after('featured_credit');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['featured_alt', 'featured_credit', 'featured_caption']);
        });
    }
};


