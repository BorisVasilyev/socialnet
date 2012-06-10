create database socialnet_db;

connect socialnet_db;

create table users
(
	id mediumint AUTO_INCREMENT,
	login varchar(100),
	password long,
	full_name varchar(100),
	reg_date datetime,
	primary key(id)
) CHARACTER SET = cp1251;

create table posts
(
	id int,
	user_id int,
	club_id int,
	title varchar(100),
	text varchar(1000)
) CHARACTER SET = cp1251;

create table comments
(
	id int,
	post_id int,
	user_login varchar(100),
	text varchar(1000),
	parent_id int
) CHARACTER SET = cp1251;

create table clubs
(
	id mediumint AUTO_INCREMENT,
	name varchar(100),
	description varchar(1000),
	primary key(id)
) CHARACTER SET = cp1251;

create table subscriptions
(
	subscriber_id int,
	publisher_id int
);