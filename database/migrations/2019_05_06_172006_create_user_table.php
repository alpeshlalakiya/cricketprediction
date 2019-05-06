<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("username")->unique();
            $table->string("password");
            $table->rememberToken();
            $table->integer('created_by')->comment('created by user id')->nullable();
            $table->integer('updated_by')->comment('updated by user id')->nullable();
            $table->integer('deleted_by')->comment('deleted by user id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index("id");
            $table->index("first_name");
            $table->index("last_name");
            $table->index("username");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
