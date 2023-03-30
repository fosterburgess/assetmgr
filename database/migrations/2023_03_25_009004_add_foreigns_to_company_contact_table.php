<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company_contact', function (Blueprint $table) {
            $table
                ->foreign('company_id')
                ->references('id')
                ->on('locations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_contact', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['contact_id']);
        });
    }
};
