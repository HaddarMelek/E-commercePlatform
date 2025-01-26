<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('category_id'); // Add category_id column
            $table->unsignedInteger('qte_stock');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('seller_id'); // Add seller_id column if needed

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade'); // Add cascade delete option

            $table->foreign('seller_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Add cascade delete option

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['category_id']);
            $table->dropForeign(['seller_id']);
        });

        Schema::dropIfExists('products');
    }
    }

