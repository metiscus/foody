drop schema foody_data;
create schema foody_data;

use foody_data;

create table fdy_food_categories 
(
	id int not null primary key AUTO_INCREMENT,
	cat_desc varchar(255) not null,
	int_cat_desc varchar(255) not null
) engine=innodb;

insert into fdy_food_categories
    values(1,"Dairy","ID_DAIRY_PRODUCTS"),
    (2,"Bread","ID_BREAD_PRODUCTS"),
    (3,"Beef","ID_BEEF_PRODUCTS"),
    (4,"Pork","ID_PORK_PRODUCTS"),
    (5,"Dry Products","ID_DRY_PRODUCTS"),
    (6,"Poultry","ID_POULTRY_PRODUCTS"),
    (7,"Produce","ID_PRODUCE_PRODUCTS"),
    (8,"Softdrinks","ID_SOFTDRINK_PRODUCTS"),
    (9,"Snack Food","ID_SNACK_FOOD_PRODUCTS"),
    (10,"Canned Goods","ID_CANNED_PRODUCTS"),
    (11,"Other","ID_OTHER_PRODUCTS");

create table fdy_food_items
(
	id int not null primary key AUTO_INCREMENT,
	category int not null,
    extern_id varchar(255),
	item_desc varchar(255) not null,
	int_item_desc varchar(255) not null,
	
	foreign key(category)
		references fdy_food_categories(id)
		on delete cascade
) engine=innodb;

insert into fdy_food_items( category, extern_id, item_desc, int_item_desc )
    values(5,'701111','Flour, white, all purpose, per lb. (453.6 gm)', 'ID_FLOUR_WHT_ALLP'),
    (5,'701312','Rice, white, long grain, uncooked, per lb. (453.6 gm)', 'ID_RICE_WHITE'),
    (2,'702111','Bread, white, pan, per lb. (453.6 gm)', 'ID_BREAD_WHITE'),
    (2,'702212','Bread, whole wheat, pan, per lb. (453.6 gm)', 'ID_BREAD_WHWHEAT'),
    (3,'703111','Ground chuck, 100% beef, per lb. (453.6 gm)', 'ID_BEEF_GROUND_CHUCK'),
    (3,'703112','Ground beef, 100% beef, per lb. (453.6 gm)', 'ID_BEEF_GROUND_BEEF'),
    (3,'703113','Ground beef, lean and extra lean, per lb. (453.6 gm)', 'ID_BEEF_GROUND_LEAN'),
    (3,'703212','Chuck roast, graded and ungraded, excluding USDA Prime and Choice, per lb. (453.6 gm)', 'ID_BEEF_CHUCK_ROAST'),
    (3,'703512','Steak, round, graded and ungraded, excluding USDA Prime and Choice, per lb. (453.6 gm)', 'ID_BEEF_ROUND_STEAK'),
    (4,'704312','Ham, boneless, excluding canned, per lb. (453.6 gm)', 'ID_HAM_BONELESS'),
    (4,'704321','Ham, canned, 3 or 5 lbs, per lb. (453.6 gm)', 'ID_HAM_CANNED'),
    (6,'706111','Chicken, fresh, whole, per lb. (453.6 gm)', 'ID_CHICKEN_WHOLE_FRESH'),
    (6,'706211','Chicken breast, bone-in, per lb. (453.6 gm)', 'ID_CHICKEN_BREAST_BONEIN'),
    (6,'706212','Chicken legs, bone-in, per lb. (453.6 gm)', 'ID_CHICKEN_LEGS_BONEIN'),
    (6,'706311','Turkey, frozen, whole, per lb. (453.6 gm)', 'ID_TURKEY_WHOLE_FROZEN'),
    (6,'708111','Eggs, grade A, large, per doz.', 'ID_EGGS_A_LG'),
    (1,'709111','Milk, fresh, whole, fortified, per 1/2 gal. (1.9 lit)', 'ID_MILK_WHOLE_HALF_GAL'),
    (1,'709112','Milk, fresh, whole, fortified, per gal. (3.8 lit)', 'ID_MILK_WHOLE_GAL'),
    (1,'709211','Milk, fresh, skim (cost per one-half gallon/1.9 liters)', 'ID_MILK_SKIM_HALF_GAL'),
    (1,'709212','Milk, fresh, low fat, per 1/2 gal. (1.9 lit)', 'ID_MILK_LOWFAT_HALF_GAL'),
    (1,'709213','Milk, fresh, low fat, per gal. (3.8 lit)', 'ID_MILK_LOWFAT_GAL'),
    (1,'710111','Butter, salted, grade AA, stick, per lb. (453.6 gm)', 'ID_BUTTER_SALTED_STICK'),
    (1,'710122','Yogurt, natural, fruit flavored, per 8 oz. (226.8 gm)', 'ID_YOGURT_FLAVORED'),
    (1,'710211','American processed cheese, per lb. (453.6 gm)', 'ID_CHEESE_AMERICAN'),
    (1,'710212','Cheddar cheese, natural, per lb. (453.6 gm)', 'ID_CHEESE_CHEDDAR'),
    (7,'711111','Apples, Red Delicious, per lb. (453.6 gm)', 'ID_APPLES_RED_DEL'),
    (7,'711211','Bananas, per lb. (453.6 gm)', 'ID_BANANAS'),
    (7,'711311','Oranges, Navel, per lb. (453.6 gm)', 'ID_ORANGES_NAVEL'),
    (7,'711312','Oranges, Valencia, per lb. (453.6 gm)', 'ID_ORANGES_VALENCIA'),
    (7,'711411','Grapefruit, per lb. (453.6 gm)', 'ID_GRAPEFRUIT'),
    (7,'711412','Lemons, per lb. (453.6 gm)', 'ID_LEMONS'),
    (7,'711413','Pears, Anjou, per lb. (453.6 gm)', 'ID_PEARS_ANJOU'),
    (7,'711414','Peaches, per lb. (453.6 gm)', 'ID_PEACHES'),
    (7,'711415','Strawberries, dry pint, per 12 oz. (340.2 gm)', 'ID_STRAWBERRIES'),
    (7,'711416','Grapes, Emperor or Tokay (cost per pound/453.6 grams)', 'ID_GRAPES_SEEDS'),
    (7,'711417','Grapes, Thompson Seedless, per lb. (453.6 gm)', 'ID_GRAPES_SEEDLESS'),
    (7,'711418','Cherries, per lb. (453.6 gm)', 'ID_CHERRIES'),
    (7,'712111','Potatoes, white (cost per pound/453.6 grams)', 'ID_POTATOES_WHITE'),
    (7,'712112','Potatoes, white, per lb. (453.6 gm)', 'ID_POTATOS_WHITE_LB'),
    (7,'712211','Lettuce, iceberg, per lb. (453.6 gm)', 'ID_LETTUCE_ICEBERG'),
    (7,'712311','Tomatoes, field grown, per lb. (453.6 gm)', 'ID_TOMATOES'),
    (7,'712401','Cabbage, per lb. (453.6 gm)', 'ID_CABBAGE'),
    (7,'712402','Celery, per lb. (453.6 gm)', 'ID_CELERY'),
    (7,'712403','Carrots, short trimmed and topped, per lb. (453.6 gm)', 'ID_CARROTS_TRIMMED'),
    (7,'712404','Onions, dry yellow, per lb. (453.6 gm)', 'ID_ONIONS_YELLOW'),
    (7,'712405','Onions, green scallions (cost per pound/453.6 grams)', 'ID_ONIONS_GREEN'),
    (7,'712406','Peppers, sweet, per lb. (453.6 gm)', 'ID_PEPPERS_SWEET'),
    (7,'712407','Corn on the cob, per lb. (453.6 gm)', 'ID_CORN_ON_COB'),
    (7,'712408','Radishes (cost per pound/453.6 grams)', 'ID_RADISHES'),
    (7,'712409','Cucumbers, per lb. (453.6 gm)', 'ID_CUCUMBERS'),
    (7,'712410','Beans, green, snap (cost per pound/453.6 grams)', 'ID_BEANS_GREEN_SNAP'),
    (7,'712411','Mushrooms (cost per pound/453.6 grams)', 'ID_MUSHROOMS'),
    (7,'712412','Broccoli, per lb. (453.6 gm)', 'ID_BROCCOLI'),
    (10,'713111','Orange juice, frozen concentrate, 12 oz. can, per 16 oz. (473.2 ml)', 'ID_JUICE_ORANGE_CONCENTRATE'),
    (10,'713311','Apple Sauce, any variety, all sizes, per lb. (453.6 gm)', 'ID_APPLE_SAUCE'),
    (7,'713312','Peaches, any variety, all sizes, per lb. (453.6 gm)', 'ID_PEACHES'),
    (9,'714111','Potatoes, frozen, French fried, per lb. (453.6 gm)', 'ID_FRENCH_FRIES'),
    (10,'714221','Corn, canned, any style, all sizes, per lb. (453.6 gm)', 'ID_CORN_CANNED'),
    (10,'714231','Tomatoes, canned, whole, per lb. (453.6 gm)', 'ID_TOMATOES_CANNED_WHOLE'),
    (10,'714232','Tomatoes, canned, any type, all sizes, per lb. (453.6 gm)', 'ID_TOMATOES_CANNED_ANY'),
    (5,'714233','Beans, dried, any type, all sizes, per lb. (453.6 gm)', 'ID_BEANS_DRIED'),
    (5,'715211','Sugar, white, all sizes, per lb. (453.6 gm)', 'ID_SUGAR_WHITE'),
    (10,'715311','Jelly (cost per pound/453.6 grams)', 'ID_JELLY'),
    (1,'716111','Margarine, vegetable oil blends, stick (cost per pound/453.6 grams)', 'ID_MARGARINE_BLEND_STICK'),
    (1,'716113','Margarine, vegetable oil blends, soft, tubs (cost per pound/453.6 grams)', 'ID_MARGARINE_BLEND_SOFT'),
    (1,'716114','Margarine, stick, per lb. (453.6 gm)', 'ID_MARGARINE_STICK'),
    (1,'716116','Margarine, soft, tubs, per lb. (453.6 gm)', 'ID_MARGARINE_SOFT'),
    (1,'716121','Shortening, vegetable oil blends, per lb. (453.6 gm)', 'ID_SHORTENING'),
    (10,'716141','Peanut butter, creamy, all sizes, per lb. (453.6 gm)', 'ID_PEANUT_BUTTER'),
    (8,'717113','Cola, nondiet, cans, 72 oz. 6 pk., per 16 oz. (473.2 ml)', 'ID_COLA_CAN'),
    (8,'717114','Cola, nondiet, per 2 liters (67.6 oz)', 'ID_COLA_2L'),
    (5,'717311','Coffee, 100%, ground roast, all sizes, per lb. (453.6 gm)', 'ID_COFFEE_GROUND'),
    (9,'718311','Potato chips, per 16 oz.', 'ID_POTATO_CHIPS'),
    (10,'718631','Pork and beans, canned (cost per 16 ounces/453.6 grams)', 'ID_PORK_BEANS_CANNED'),
    (3,'FC1101','All uncooked ground beef, per lb. (453.6 gm)', 'ID_BEEF_GROUND_ALL'),
    (3,'FC2101','All Uncooked Beef Roasts, per lb. (453.6 gm)', 'ID_BEEF_ROAST_ALL'),
    (3,'FC3101','All Uncooked Beef Steaks, per lb. (453.6 gm)', 'ID_BEEF_STEAK_ALL'),
    (3,'FC4101','All Uncooked Other Beef (Excluding Veal), per lb. (453.6 gm)', 'ID_MEAT_OTHER'),
    (4,'FD2101','All Ham (Excluding Canned Ham and Luncheon Slices), per lb. (453.6 gm)', 'ID_HAM_ALL'),
    (4,'FD3101','All Pork Chops, per lb. (453.6 gm)', 'ID_PORK_CHOP_ALL'),
    (4,'FD4101','All Other Pork (Excluding Canned Ham and Luncheon Slices), per lb. (453.6 gm)', 'ID_PORK_OTHER_ALL'),
    (6,'FF1101','Chicken breast, boneless, per lb. (453.6 gm)', 'ID_CHICKEN_BREAST_BONELESS');

create table fdy_regions
(
	id int not null primary key AUTO_INCREMENT,
    extern_id varchar(128),
	reg_desc varchar(255) not null,
	int_reg_descc varchar(255) not null
) engine=innodb;

insert into fdy_regions
    values(1,"0000","US City Average","ID_US_CITY_AVERAGE"),
    (2,"0100","Northeastern Cities US","ID_NORTHEASTERN_US"),
    (3,"0200","Midwestern Cities US","ID_MIDWEST_US"),
    (4,"0300","Southern Cities US","ID_SOUTHERN_US"),
    (5,"0400","West Cities US","ID_WEST_US");

create table fdy_state_to_region
(
	id int not null,
    name varchar(100) not null,
    state_abbr char(2) not null,
	region int not null,

	primary key(state_abbr),

	foreign key(region)
		references fdy_regions(id)
		on delete cascade
) engine=innodb;

insert into fdy_state_to_region
    VALUES(1,'Alabama','AL',4),
    (2,'Alaska','AK',5),
    (3,'Arizona','AZ',5),
    (4,'Arkansas','AR',4),
    (5,'California','CA',5),
    (6,'Colorado','CO',5),
    (7,'Connecticut','CT',2),
    (8,'Delaware','DE',4),
    (9,'Florida','FL',4),
    (10,'Georgia','GA',4),
    (11,'Hawaii','HI',5),
    (12,'Idaho','ID',5),
    (13,'Illinois','IL',3),
    (14,'Indiana','IN',3),
    (15,'Iowa','IA',3),
    (16,'Kansas','KS',3),
    (17,'Kentucky','KY',4),
    (18,'Louisiana','LA',4),
    (19,'Maine','ME',2),
    (20,'Maryland','MD',4),
    (21,'Massachusetts','MA',2),
    (22,'Michigan','MI',3),
    (23,'Minnesota','MN',3),
    (24,'Mississippi','MS',4),
    (25,'Missouri','MO',3),
    (26,'Montana','MT',5),
    (27,'Nebraska','NE',3),
    (28,'Nevada','NV',5),
    (29,'New Hampshire','NH',2),
    (30,'New Jersey','NJ',2),
    (31,'New Mexico','NM',5),
    (32,'New York','NY',2),
    (33,'North Carolina','NC',4),
    (34,'North Dakota','ND',3),
    (35,'Ohio','OH',3),
    (36,'Oklahoma','OK',4),
    (37,'Oregon','OR',5),
    (38,'Pennsylvania','PA',2),
    (39,'Rhode Island','RI',2),
    (40,'South Carolina','SC',4),
    (41,'South Dakota','SD',3),
    (42,'Tennessee','TN',4),
    (43,'Texas','TX',4),
    (44,'Utah','UT',5),
    (45,'Vermont','VT',2),
    (46,'Virginia','VA',4),
    (47,'Washington','WA',5),
    (48,'West Virginia','WV',4),
    (49,'Wisconsin','WI',3),
    (50,'Wyoming','WY',5);

create table fdy_item_price_source
(
    id int not null primary key AUTO_INCREMENT,
    note varchar(255)
) engine=innodb;

insert into fdy_item_price_source
values (1, 'BLS Data (http://www.bls.gov)'),
(2, 'User Reported');

create table fdy_item_prices
(
    item_id int not null,
    region_id int not null,
    price float,
    updated date,
    source int not null,
    
    foreign key(item_id)
        references fdy_food_items(id)
        on delete cascade,
    
    foreign key(region_id)
        references fdy_regions(id)
        on delete cascade,
    
    foreign key(source)
        references fdy_item_price_source(id)
        on delete cascade,
    
    primary key(item_id, region_id)
) engine=innodb;

/*
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
*/