<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupsTable extends Migration
{
    public function up()
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_id')->unique()->nullable();  // your new pickup id column
            $table->string('pickup_date')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('drop_location')->nullable();
            $table->string('size_of_vehicle')->nullable();
            $table->string('email')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('contact')->nullable();
            $table->string('status')->nullable(); 
            $table->string('advance_paid');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pickups');
    }
}
