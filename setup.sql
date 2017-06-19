DROP TABLE appuser CASCADE;
DROP TABLE courses CASCADE;
DROP TABLE iGetIt CASCADE;

CREATE TABLE appuser
(
id SERIAL primary key,
username varchar(255),
password varchar(255),
email varchar(255),
firstname varchar(255),
lastname varchar(255),
type varchar(255),
firsttime varchar(255));

CREATE TABLE Courses
(
id SERIAL primary key,
name varchar(255),
instructor varchar(255),
code varchar(255));

CREATE TABLE iGetIt
(
uid int references appuser(id),
cid int references courses(id),
getit varchar(255));
