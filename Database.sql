--create the database
create database if not exists student_management;
use student_management;
--create the student table
create table if not exists student(
    id int auto_increment primary key,
    student-name varchar(255)not null,
    email varcher(255)not null unique,
    student-number varchar (50)not null unique,
    year-of-study int not null,
    batch-name varchar (100)not null,
    create-at timestamp default current-timestamp
);