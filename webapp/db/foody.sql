drop schema foody_data;
create schema foody_data;

use foody_data;

create table fdy_food_categories 
(
	id int not null AUTO_INCREMENT,
	desc varchar(255) not null,
	int_desc varchar(255) not null,
	primary key(id)
) engine=innodb;

create table fdy_food_items
(
	id int not null AUTO_INCREMENT,
	category int not null,
	desc varchar(255) not null,
	int_desc varchar(255) not null,
	
	foreign key(category)
		references fdy_food_categories(id)
		on delete cascade
) engine=innodb;
