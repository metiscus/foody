drop schema foody_data;
create schema foody_data;

use foody_data;

create table fdy_food_categories 
(
	id int not null primary key AUTO_INCREMENT,
	cat_desc varchar(255) not null,
	int_cat_desc varchar(255) not null
) engine=innodb;

create table fdy_food_items
(
	id int not null primary key AUTO_INCREMENT,
	category int not null,
	item_desc varchar(255) not null,
	int_item_descc varchar(255) not null,
	
	foreign key(category)
		references fdy_food_categories(id)
		on delete cascade
) engine=innodb;

create table fdy_regions
(
	id int not null primary key AUTO_INCREMENT,
	reg_desc varchar(255) not null,
	int_reg_descc varchar(255) not null
) engine=innodb;

create table fdy_state_to_region
(
	state_abbr char(2) not null,
	region int not null,

	primary key(state_abbr),

	foreign key(region)
		references fdy_regions(id)
		on delete cascade
) engine=innodb;

create table fdy_chains
(
	id int not null primary key AUTO_INCREMENT,
	chain_desc varchar(255) not null,
	int_chain_desc varchar(255) not null
) engine=innodb;

create table fdy_locations
(
	id int not null primary key AUTO_INCREMENT,
    chain int not null,
	loc_desc varchar(255) not null,
	int_loc_desc varchar(255) not null,
	lat double precision not null,
	lon double precision not null,
	foreign key(chain)
		references fdy_chains(id)
		on delete cascade
) engine=innodb;

create table fdy_users
(
	id int not null primary key AUTO_INCREMENT,
	uid char(40) not null,
	banned boolean not null default 1
) engine=innodb;

create table fdy_price_report
(
	id int not null primary key AUTO_INCREMENT,
	location int not null,
	item int not null,
	userid int not null,
	
	foreign key(userid)
		references fdy_users(id)
		on delete cascade,

	foreign key(location)
		references fdy_locations(id)
		on delete cascade,

	foreign key(item)
		references fdy_food_items(id)
		on delete cascade
) engine=innodb;
