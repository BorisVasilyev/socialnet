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
);

create table posts
(
	id int,
	user_id int,
	club_id int,
	title varchar(100),
	text varchar(1000)
);

create table comments
(
	id int,
	post_id int,
	user_login varchar(100),
	text varchar(1000),
	parent_id int
);

create table clubs
(
	id int,
	name varchar(100),
	description varchar(1000)
);

create table subscriptions
(
	subscriber_id int,
	publisher_id int
);