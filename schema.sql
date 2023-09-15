-- Customer
-- cst_id int not null
-- national_id int not null FK
-- cst_name varchar(50) not null
-- cst_dob date not null
-- cst_phoneNum varchar(20) not null
-- cst_email varchar(50) not null

-- Family List
-- fl_id int not null
-- cst_id int not null FK
-- fl_relation varchar(20) not null
-- fl_name varchar(50) not null
-- fl_dob date not null

-- Nationality
-- national_id  int not null
-- national_name varchar(50) not null
-- national_code varchar(2) not null

CREATE TABLE IF NOT EXIST nationality (
    national_id serial not null primary key,
    national_name varchar(50) not null,
    national_code varchar(2) not null,
);

CREATE TABLE IF NOT EXIST customer (
    cst_id serial not null primary key,
    national_id int not null,
    cst_name varchar(50) not null,
    cst_dob date not null,
    cst_phoneNum varchar(20) not null,
    cst_email varchar(50) not null,
);

ALTER TABLE customer ADD CONSTRAINT nationality_customer_to_fkey FOREIGN KEY (national_id) REFERENCES nationality (id);

CREATE TABLE IF NOT EXIST family_list (
    fl_id serial not null primary key,
    cst_id int not null,
    fl_relation varchar(20) not null,
    fl_name varchar(50) not null,
    fl_dob date not null,
);

ALTER TABLE family_list ADD CONSTRAINT customer_family_list_to_fkey FOREIGN KEY (cst_id) REFERENCES customer (id);