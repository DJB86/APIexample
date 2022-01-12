# A basic API example using the Lumen micro-framework

## Running locally
A local dev server can be started in the root folder with `php -S localhost:8000 -t public` with the API then available at `localhost:8000/api/v1/`.
As per validation rules set in `StudentRecordController.php` (see below), the following rules are in effect for API calls:
- All fields are required
- FirstName and Surname are alpha characters only
- DateOfBirth must be a valid date
- Sex can be "M", "F" or "O" for male, female or other (for "do not wish to disclose" option) respectively
- Gender can be any string to account for the myriad possibilities
- Phone number regex is just basic 0 followed by 9 or 10 digits, this would be improved to validate __which__ numbers are only 10 digits total (eg: London dialling codes)
- Address is simply a string, this would be improved to split the address parameters out and validate against a list of counties and regex for valid postcodes

Incorrect input will return a JSON object highlighting which parameters are incorrect.

## Routes
Routing for endpoints is located in `routes/web.php`

## Database functions
Handling of incoming queries is located in `app/Http/Controllers/StudentRecordController.php`

## Tests
Basic test functions are located in `tests/APITest.php`

## Database setup
DB schema is located in `database/migrations/2022_01_10_203139_create_student_table.php`
