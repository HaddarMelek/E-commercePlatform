<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['seller_id']);

            // Add the foreign key constraint with cascading deletes
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback foreign key modification
            $table->dropForeign(['seller_id']);

            // Re-add the foreign key constraint without cascading deletes
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('users');
        });
    }
}
