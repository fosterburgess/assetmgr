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
        Schema::table('contact_manufacturer', function (Blueprint $table) {
            $table
                ->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_manufacturer', function (Blueprint $table) {
            $table->dropForeign(['contact_id']);
            $table->dropForeign(['manufacturer_id']);
        });
    }
};
