drop schema foody_telemetry;
create schema foody_telemetry;

use foody_telemetry;

create table tel_trans 
(
	id int not null AUTO_INCREMENT,
	uid char(40) not null,
	time timestamp,
	primary key(id)
) engine=innodb;

create table tel_trans_data
(
	trans int not null,
	tkey int,
	tvalue varchar(255),
	
	foreign key(trans)
		references tel_trans(id)
		on delete cascade
) engine=innodb;
