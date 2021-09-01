## Hospital app

Hospital application for managing patient registrations and prescriptions.
Appointment is reserved for 10 minutes 

### Set up the project:
- clone repository
- run in terminal : docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/opt \
  -w /opt \
  laravelsail/php80-composer:latest \
  composer install --ignore-platform-reqs
- rename .env.example file, change database host to mysql
default: 
  - DB_CONNECTION=mysql
  - DB_HOST=mysql
  - DB_PORT=3306
  - DB_DATABASE=hospital_app
  - DB_USERNAME=sail
  - DB_PASSWORD=password
- setup mailer, I used mailtrap, where you can just copy the parameters given there
- fill MAIL_FROM_ADDRESS
- change sync to database for queues
- run vendor/bin/sail up - to start containers
- now in another tab run these commands:
- vendor/bin/sail artisan migrate:fresh
- vendor/bin/sail artisan db:seed  - can take a while
- vendor/bin/sail artisan key:generate
- open new console tab and run queue worker for reservations and prescriptions: ./vendor/bin/sail artisan queue:work --queue=reservations

Database seed will generate 3 users

- email:receptionist@example.com password:test1234 , the user has role 'receptionist can create appointments for users, cancel them or change the time of an appointment.
- email:doctor@example.com password:test1234, the user has role 'doctor' can view patients that have an appointment with him or all patients and prescribe selected drugs to patients
- email:doctor1@example.com password:test1234, the user has role 'doctor' can view patients that have an appointment with him or all patients and prescribe selected drugs to patients

- api endpoint url/api/prescriptions returns all prescribed drugs for patients

###Testing

- for testing there is another database created, ant it can be configured in .env.testing file
- to run tests : vendor/bin/sail test
