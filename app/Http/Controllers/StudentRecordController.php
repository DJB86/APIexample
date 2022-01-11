<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Database\QueryException;
use Exception;
use Log;

class StudentRecordController extends Controller {
	// Validator rules
	const StudentRecordRules = [
		'FirstName'		=> 'required|alpha',
		'Surname'		=> 'required|alpha',
		'DateOfBirth'	=> 'required|date',
		'Sex'			=> 'required|in:M,F,O',
		'Gender'		=> 'required|string',
		'PhoneNumber'	=> 'required|regex:/^(0)[0-9]{9,10}$/',
		'Address'		=> 'required|string'
	];
	
	// List all students
    public function studentList () {
		$students = DB::table('student')->get();
		return response()->json($students);
	}
	// Fetch a single student by ID
	public function studentByID ($studentID) {
		try {
			$student = DB::table('student')
				->where('id', $studentID)
				->first();
			if ($student) {
				return response()->json($student);
			} else {
				return response()->json(['error' => ['code' => '422', 'message' => 'No students with that ID']], 422);
			}
		} catch (Exception $e) {
			// Errors are already in JSON format
			return response($e->getMessage(), 422);
		}
	}
	// Create new student record
	public function addStudent (Request $request) {
		$validator = Validator::make($request->all(), self::StudentRecordRules);
		if ($validator->fails()) {
			return response()->json($validator->messages(), 422);
		} else {
			$studentData = array(
				'FirstName'		=> $request->input('FirstName'),
				'Surname'		=> $request->input('Surname'),
				'DateOfBirth'	=> $request->input('DateOfBirth'),
				'Sex'			=> $request->input('Sex'),
				'Gender'		=> $request->input('Gender'),
				'PhoneNumber'	=> $request->input('PhoneNumber'),
				'Address'		=> $request->input('Address')
			);
			try {
				$newStudent = DB::table('student')
					->insertGetId($studentData);
				return response()->json(['success' => 'success', 'newStudentID' => $newStudent], 201);
			} catch (Exception $e) {
				// Errors are already in JSON format
				return response($e->getMessage(), 422);
			}
		}
	}
	// Update an existing record
	public function updateStudent (Request $request, $studentID) {
		$validator = Validator::make($request->all(), self::StudentRecordRules);
		if ($validator->fails()) {
			return response()->json($validator->messages(), 422);
		} else {
			$studentData = array(
				'FirstName'		=> $request->input('FirstName'),
				'Surname'		=> $request->input('Surname'),
				'DateOfBirth'	=> $request->input('DateOfBirth'),
				'Sex'			=> $request->input('Sex'),
				'Gender'		=> $request->input('Gender'),
				'PhoneNumber'	=> $request->input('PhoneNumber'),
				'Address'		=> $request->input('Address'),
			);
			$recordExists = DB::table('student')
				->where('id', $studentID)
				->exists();
			if (!$recordExists) {
				return response()->json(['error' => 'error', 'message' => 'No students with that ID'], 422);
			}
			try {
				DB::table('student')
					->where('id', $studentID)
					->update($studentData);
				return response()->json(['success' => 'success'], 200);
			} catch (Exception $e) {
				// Errors are already in JSON format
				return response($e->getMessage(), 422);
			}
		}
	}
	// Hard delete a record
	public function deleteStudent ($studentID) {
		try {
			DB::table('student')
				->where('id', $studentID)
				->delete();
			return response()->json(['success' => 'success'], 200);
		} catch (Exception $e) {
			// Errors are already in JSON format
			return response($e->getMessage(), 422);
		}
	}
}
