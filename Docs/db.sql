--un comment on first run
--CREATE database WildeKlawerTydkaarte;

--create new tables
DROP TABLE plaas;
CREATE TABLE plaas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));

insert into plaas (naam) values ('ROM');
insert into plaas (naam) values ('DB');

DROP TABLE gewas;
CREATE TABLE gewas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));
	
insert into gewas (naam) values ('Uie');
insert into gewas (naam) values ('Aartappels');
insert into gewas (naam) values ('Wortels');
insert into gewas (naam) values ('Beet');

DROP TABLE Spilpunt;
CREATE TABLE Spilpunt ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254),
	farm_id INT UNSIGNED NOT NULL);

insert into Spilpunt (farm_id,naam) values (1,'T1');
insert into Spilpunt (farm_id,naam) values (1,'T2');

DROP TABLE Task;
CREATE TABLE Task ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));

insert into Task (naam) values ('Oes');
insert into Task (naam) values ('Plant');
insert into Task (naam) values ('Skoffel');

DROP TABLE users;
CREATE TABLE users( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	van VARCHAR(254) NOT NULL,
	CN INT UNSIGNED NOT NULL,
	pwd VARCHAR(254),
	farm_id INT UNSIGNED NOT NULL,
	accesslevel INT UNSIGNED NOT NULL);

insert into users (naam,van,CN,pwd,farm_id,accesslevel) values ('admin','system',0,'1234',1,7);
insert into users (naam,van,CN,pwd,farm_id,accesslevel) values ('admin','worker',0,'1111',1,4);

DROP TABLE workers;
CREATE TABLE workers( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	van VARCHAR(254) NOT NULL,
	CN INT UNSIGNED NOT NULL);

DROP TABLE access;
CREATE TABLE access( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	beskrywing VARCHAR(254));

INSERT INTO access(naam)
    VALUES ( 'Guest');

INSERT INTO access(naam)
    VALUES ( '2');

INSERT INTO access(naam)
    VALUES ( '3');

INSERT INTO access(naam)
    VALUES ( 'User Admin');

INSERT INTO access(naam)
    VALUES ( '5');

INSERT INTO access(naam)
    VALUES ( '6');

INSERT INTO access(naam)
    VALUES ( 'System Admin');
