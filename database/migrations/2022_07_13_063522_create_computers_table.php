<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->text('os_name');
            $table->text('os_version');
            $table->text('proc_info');
            $table->text('gpu_info');
            $table->text('disk_info');
            $table->text('system_ram');
            $table->text('model_info');
            $table->text('hash');
            $table->text('serial')->unique();
            $table->text('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computers');
    }
}
