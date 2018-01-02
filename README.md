# sms - Student Management System

A simple project made using bootstrap/php to manage students.

This project has 3 types of users Admin, Attendant, Student. - all users can be viewed on admindb.php

Based on the logged in user type, respective dashboard will be opened.



# Installation

After downloading the source folder in php/mysql server.
- Import the sms.sql to a mysql database with a name "sms" (use phpmyadmin).
- Configure your database user details on "includes/db_connection.php" file.
- Run the project.

Admin account details.
userid   - admin
password - 1234

Note- All other accounts have same password - 1234



# Documentation

1) There will be 3 types of users:
    - Student
    - Attendant
    - Admin
    
2) Student:
    If student logs in, he is presented with a dashboard where he sees 3 options:
        - Profile: Student can change his e-mail, phone or password.
        - Check Attendance: Student can select a previous date from a calendar and see his attendance for that date.
        - Book studio: After selecting the date Student can book studio. Please note that only 2 bookings can be made for 1 day.
        
3) Attendant:
     If attendant logs in, he is presented with a dashboard where he sees 3 options:
     - Mark Attendance: The attendant should be able to mark attendance (present or absent) of the student for the current day.
     - View Attendance: The attendant should be able to see their previous attendance.
     - Book studio: The attendant should be able to book studio for a student.
        
4) Admin:
 	 If admin logs in, he is presented with a dashboard where he sees the following options:
    - Add Users : Admin can add / edit / delete a user.
    - View / Mark Attendance: The attendant should be able to view / mark attendance (present or absent) of the student.
    - Book Studio : The Admin should be able to book studio for a student. Admin can accept or reject a booking for the student.




Regards,

Kamna Gautam
