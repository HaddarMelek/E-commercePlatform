<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersForeignKey extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['user_id']);

            // Add the foreign key constraint with cascading deletes
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Rollback foreign key modification
            $table->dropForeign(['user_id']);

            // Re-add the foreign key constraint without cascading deletes
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }
}
