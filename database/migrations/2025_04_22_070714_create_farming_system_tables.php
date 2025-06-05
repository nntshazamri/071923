<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFarmingSystemTables extends Migration
{
    public function up()
    {
        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->increments('userID');
            $table->string('name', 100);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('phoneNo', 20)->nullable();
            $table->enum('role', ['admin', 'farmer'])->default('farmer');
            $table->timestamps();
        });

        // Sample Users Insert
        DB::table('users')->insert([
            ['userID' => 1, 'name' => 'Alice', 'email' => 'alice@example.com', 'password' => bcrypt('pa$$word1'), 'phoneNo' => '555-0100', 'role' => 'farmer'],
            ['userID' => 2, 'name' => 'Bob', 'email' => 'bob@example.com', 'password' => bcrypt('b0bSecure'), 'phoneNo' => '555-0200', 'role' => 'admin'],
            ['userID' => 3, 'name' => 'Carol', 'email' => 'carol@example.com', 'password' => bcrypt('c@rol123'), 'phoneNo' => '555-0300', 'role' => 'farmer'],
            ['userID' => 4, 'name' => 'Dave', 'email' => 'dave@example.com', 'password' => bcrypt('dAv3!789'), 'phoneNo' => '555-0400', 'role' => 'farmer'],
        ]);

        // Farms Table
        Schema::create('farms', function (Blueprint $table) {
            $table->increments('farmID');
            $table->string('location', 255);
            $table->decimal('size', 10, 2);
        });

        // Sample Farms Insert
        DB::table('farms')->insert([
            ['farmID' => 101, 'location' => 'East Valley', 'size' => 10.5],
            ['farmID' => 102, 'location' => 'South Ridge', 'size' => 12.0],
            ['farmID' => 103, 'location' => 'North Plateau', 'size' => 8.75],
        ]);

        // UserFarms Table (Junction table)
        Schema::create('user_farms', function (Blueprint $table) {
            $table->integer('userID')->unsigned();
            $table->integer('farmID')->unsigned();
            $table->primary(['userID', 'farmID']);
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('farmID')->references('farmID')->on('farms')->onDelete('cascade');
        });

        // Sample User-Farm links Insert
        DB::table('user_farms')->insert([
            ['userID' => 1, 'farmID' => 101], // Alice → East Valley
            ['userID' => 1, 'farmID' => 102], // Alice → South Ridge
            ['userID' => 2, 'farmID' => 101], // Bob → East Valley
            ['userID' => 3, 'farmID' => 103], // Carol → North Plateau
            ['userID' => 4, 'farmID' => 102], // Dave → South Ridge
        ]);

        // Sensors Table
        Schema::create('sensors', function (Blueprint $table) {
            $table->increments('sensorID');
            $table->integer('farmID')->unsigned();
            $table->string('type', 50);
            $table->string('status', 20);
            $table->string('location', 100);
            $table->foreign('farmID')->references('farmID')->on('farms')->onDelete('cascade');
        });

        // Sample Sensors Insert
        DB::table('sensors')->insert([
            ['sensorID' => 1001, 'farmID' => 101, 'type' => 'moisture', 'status' => 'online', 'location' => 'Sector B3'],
            ['sensorID' => 1002, 'farmID' => 101, 'type' => 'pH', 'status' => 'online', 'location' => 'Sector B3'],
            ['sensorID' => 1003, 'farmID' => 102, 'type' => 'moisture', 'status' => 'offline', 'location' => 'Sector A1'],
            ['sensorID' => 1004, 'farmID' => 103, 'type' => 'pH', 'status' => 'online', 'location' => 'Sector C2'],
        ]);

        // SensorDataLog Table
        Schema::create('sensor_data_log', function (Blueprint $table) {
            $table->increments('logID');
            $table->integer('sensorID')->unsigned();
            $table->integer('farmID')->unsigned();
            $table->decimal('moistureLevel', 5, 2)->nullable();
            $table->decimal('pHValue', 4, 2)->nullable();
            $table->timestamp('timestamp');
            $table->foreign('sensorID')->references('sensorID')->on('sensors')->onDelete('cascade');
            $table->foreign('farmID')->references('farmID')->on('farms')->onDelete('cascade');
        });

        // Sample SensorDataLog Insert
        DB::table('sensor_data_log')->insert([
            ['logID' => 5001, 'sensorID' => 1001, 'farmID' => 101, 'moistureLevel' => 21.5, 'pHValue' => null, 'timestamp' => '2025-04-20 08:00:00'],
            ['logID' => 5002, 'sensorID' => 1002, 'farmID' => 101, 'moistureLevel' => null, 'pHValue' => 6.8, 'timestamp' => '2025-04-20 08:05:00'],
            ['logID' => 5003, 'sensorID' => 1003, 'farmID' => 102, 'moistureLevel' => 18.2, 'pHValue' => null, 'timestamp' => '2025-04-20 08:10:00'],
            ['logID' => 5004, 'sensorID' => 1004, 'farmID' => 103, 'moistureLevel' => null, 'pHValue' => 7.1, 'timestamp' => '2025-04-20 08:15:00'],
            ['logID' => 5005, 'sensorID' => 1001, 'farmID' => 101, 'moistureLevel' => 22.0, 'pHValue' => null, 'timestamp' => '2025-04-21 09:00:00'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('sensor_data_log');
        Schema::dropIfExists('sensors');
        Schema::dropIfExists('user_farms');
        Schema::dropIfExists('farms');
        Schema::dropIfExists('users');
    }
}
