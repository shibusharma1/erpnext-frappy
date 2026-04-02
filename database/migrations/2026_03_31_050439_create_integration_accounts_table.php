<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_accounts', function (Blueprint $table) {
            $table->id();

            // Link to your system
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();

            // Provider info (zoho, tally, erpnext, sap, busy etc)
            $table->string('provider', 100)->index(); // ex: zoho, tally, erpnext
            $table->string('service_type', 100)->nullable()->index(); // ex: zoho_books, zoho_inventory

            // Provider specific IDs
            $table->string('organization_id', 255)->nullable()->index(); // zoho org id / erpnext company id
            $table->string('account_id', 255)->nullable()->index(); // external user/account id if exists

            // OAuth Client Credentials (if required)
            $table->string('client_id', 255)->nullable();
            $table->text('client_secret')->nullable(); // use text for long secrets

            // URLs (useful for dynamic base URLs per provider)
            $table->text('auth_url')->nullable();
            $table->text('token_url')->nullable();
            $table->text('redirect_uri')->nullable();
            $table->text('api_base_url')->nullable();

            // OAuth Tokens
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->text('id_token')->nullable();

            $table->string('token_type', 50)->nullable(); // Bearer
            $table->text('scope')->nullable();

            // Expiry and revoke timestamps
            $table->integer('expires_in')->nullable(); // seconds
            $table->timestamp('access_token_expires_at')->nullable()->index();
            $table->timestamp('refresh_token_expires_at')->nullable()->index();
            $table->timestamp('revoked_at')->nullable()->index();

            // If integration requires API key instead of OAuth
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();

            // Store extra provider config (ex: region, datacenter, accounts_url etc)
            $table->json('settings')->nullable();

            // Store complete raw responses (best practice)
            $table->json('token_response')->nullable();
            $table->json('meta')->nullable();

            // Status
            $table->boolean('is_active')->default(true)->index();
            $table->timestamp('last_synced_at')->nullable();

            $table->timestamps();

            // Prevent duplicate provider account connection
            $table->unique(
                ['company_id', 'provider', 'service_type', 'organization_id'],
                'unique_company_provider_service_org'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_accounts');
    }
};