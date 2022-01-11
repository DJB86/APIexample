<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('student', function (Blueprint $table) {
			// A student record requires the following fields: student id, first name, surname, date of birth, sex, gender, phone number, address;
            $table->id();
            $table->string('FirstName', 20);
            $table->string('Surname', 20);
            $table->date('DateOfBirth');
            $table->string('Sex', 1);
            $table->string('Gender', 20);
			$table->string('PhoneNumber', 20);
            $table->string('Address', 512);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()  {
        Schema::dropIfExists('student');
    }
}
