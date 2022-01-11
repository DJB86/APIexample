<?php
use Illuminate\Http\Request ;
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// - API calls ---------------------------------------------------------
$router->group(['prefix' => 'api/v1'], function ($router) {
	/*
	 A student record requires the following fields: student id, first name, surname, date of birth, sex, gender, phone number, address;
	- GET /student – retrieve all students
	- GET /student/{id} – retrieve student with supplied ID
	- POST /student – create a new student from the supplied data.
	- PUT /student/{id} – update an existing student.
	- DELETE /student/{id} – delete the student with the supplied ID
	*/

	// Get list of students
	$router->get('student', 'StudentRecordController@studentList');
	// Get a student by ID
	$router->get('student/{studentID}', 'StudentRecordController@studentByID');
	// Add a student record
	$router->post('student', 'StudentRecordController@addStudent');
	// Update a service
	$router->put('student/{studentID}', 'StudentRecordController@updateStudent');
	// Delete a service
	$router->delete('student/{studentID}', 'StudentRecordController@deleteStudent');
});
