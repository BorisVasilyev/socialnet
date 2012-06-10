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
) CHARACTER SET = utf8;

create table posts
(
	id mediumint AUTO_INCREMENT,
	user_id int,
	club_id int,
	title varchar(100),
	text varchar(1000),
	primary key(id)
) CHARACTER SET = utf8;

create table comments
(
	id mediumint AUTO_INCREMENT,
	post_id int,
	user_login varchar(100),
	text varchar(1000),
	parent_id int,
	primary key(id)
) CHARACTER SET = utf8;

create table clubs
(
	id mediumint AUTO_INCREMENT,
	name varchar(100),
	description varchar(1000),
	primary key(id)
) CHARACTER SET = utf8;

create table user_subscriptions
(
	subscriber_id int,
	publisher_id int
);

create table club_subscriptions
(
	subscriber_id int,
	club_id int
);