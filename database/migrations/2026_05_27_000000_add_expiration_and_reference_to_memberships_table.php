<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            if (! Schema::hasColumn('memberships', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('payment_method');
            }
            if (! Schema::hasColumn('memberships', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            if (Schema::hasColumn('memberships', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
            if (Schema::hasColumn('memberships', 'reference_number')) {
                $table->dropColumn('reference_number');
            }
        });
    }
};
