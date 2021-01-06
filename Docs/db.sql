CREATE database WildeKlawerTydkaarte;

--create new tables
CREATE TABLE plaas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);

insert into plaas (naam) values ('ROM');
insert into plaas (naam) values ('DB');

CREATE TABLE gewas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);
	
insert into gewas (naam) values ('Uie');
insert into gewas (naam) values ('Aartappels');
insert into gewas (naam) values ('Wortels');
insert into gewas (naam) values ('Beet');

CREATE TABLE Spilpunt ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);

insert into Spilpunt (naam) values ('T1');
insert into Spilpunt (naam) values ('T2');

CREATE TABLE Task ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);

insert into Task (naam) values ('Oes');
insert into Task (naam) values ('Plant');
insert into Task (naam) values ('Skoffel');


CREATE TABLE users( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	van VARCHAR(254) NOT NULL,
	CN INT UNSIGNED NOT NULL,
	pwd VARCHAR(254),
	accesslevel INT UNSIGNED NOT NULL);

insert into users (naam,van,CN,pwd,accesslevel) values ('admin','system',0,'1234',7);
insert into users (naam,van,CN,pwd,accesslevel) values ('admin','worker',0,'1111',4);

CREATE TABLE workers( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	van VARCHAR(254) NOT NULL,
	CN INT UNSIGNED NOT NULL);

CREATE TABLE access( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);

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
