<?php

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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable()->after('password');
            }
            if (! Schema::hasColumn('users', 'stripe_subscription_id')) {
                $table->string('stripe_subscription_id')->nullable();
            }
            if (! Schema::hasColumn('users', 'subscription_status')) {
                $table->string('subscription_status')->nullable();
            }
            if (! Schema::hasColumn('users', 'plan')) {
                $table->string('plan')->default('basic');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefone', 'stripe_customer_id', 'stripe_subscription_id', 'subscription_status', 'plan']);
        });
    }
};
