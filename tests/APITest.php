<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class APITest extends TestCase {
	/*
	 A student record requires the following fields: student id, first name, surname, date of birth, sex, gender, phone number, address;
	- GET /student – retrieve all students
	- GET /student/{id} – retrieve student with supplied ID
	- POST /student – create a new student from the supplied data.
	- PUT /student/{id} – update an existing student.
	- DELETE /student/{id} – delete the student with the supplied ID
	*/
	
	// GET student
    public function testShouldReturnAllStudents () {
        $this->get("api/v1/student", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
				'id',
				'FirstName',
				'Surname',
				'DateOfBirth',
				'Sex',
				'Gender',
				'PhoneNumber',
				'Address'
			]
        ]);
    }
    // GET student/id
    public function testShouldReturnStudent () {
        $this->get("api/v1/student/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
			'id',
			'FirstName',
			'Surname',
			'DateOfBirth',
			'Sex',
			'Gender',
			'PhoneNumber',
			'Address'
        ]);
    }
    public function testShouldntReturnStudent () {
		$this->get("api/v1/student/toast", []);
		$this->seeStatusCode(422);
	}
    // POST student
    public function testShouldCreateStudent () {
		$parameters = array(
			'FirstName'		=> 'Douglas',
			'Surname'		=> 'Adams',
			'DateOfBirth'	=> '1952-03-11',
			'Sex'			=> 'M',
			'Gender'		=> 'Depressed Robot',
			'PhoneNumber'	=> '01742424242',
			'Address'		=> 'Milliways, The End of Time and Matter, The Universe (The End Of)'
		);
		$this->post("api/v1/student", $parameters, []);
		$this->seeStatusCode(201);
		$this->seeJsonStructure([
			'success',
			'newStudentID',
		]);
	}
	public function testShouldntCreateStudent () {
		$parameters = array(
			'FirstName'		=> '',
			'Surname'		=> 'Adams',
			'DateOfBirth'	=> '1952-03-11',
			'Sex'			=> 'M',
			'Gender'		=> 'Depressed Robot',
			'PhoneNumber'	=> 'Dial M for memes',
			'Address'		=> 'Milliways, The End of Time and Matter, The Universe (The End Of)'
		);
		$this->post("api/v1/student", $parameters, []);
		$this->seeStatusCode(422);
	}
	// PUT student
	public function testShouldUpdateStudent () {
		$parameters = array(
			'FirstName'		=> 'Zaphod',
			'Surname'		=> 'Beeblebrox',
			'DateOfBirth'	=> '1952-03-11',
			'Sex'			=> 'M',
			'Gender'		=> 'Genderfluid',
			'PhoneNumber'	=> '01742424242',
			'Address'		=> 'Milliways, The End of Time and Matter, The Universe (The End Of)'
		);
		$this->put("api/v1/student/1", $parameters, []);
		$this->seeStatusCode(200);
		$this->seeJsonEquals([
			'success' => 'success'
		]);
	}
	public function testShouldntUpdateStudent () {
		$parameters = array(
			'FirstName'		=> '',
			'Surname'		=> 'Adams',
			'DateOfBirth'	=> '1952-03-11',
			'Sex'			=> 'M',
			'Gender'		=> 'Depressed Robot',
			'PhoneNumber'	=> 'Dial M for memes',
			'Address'		=> 'Milliways, The End of Time and Matter, The Universe (The End Of)'
		);
		$this->put("api/v1/student/1", $parameters, []);
		$this->seeStatusCode(422);
	}
	// DELETE student
	public function testShouldDeleteStudent () {
		$this->delete("api/v1/student/2", []);
		$this->seeStatusCode(200);
		$this->seeJsonEquals([
			'success' => 'success'
		]);
	}
}
