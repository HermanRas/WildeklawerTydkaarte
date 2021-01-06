CREATE database WildeKlawerTydkaarte;

--create new tables
CREATE TABLE plaas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);

CREATE TABLE gewas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL);

CREATE TABLE users( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	pwd VARCHAR(254),
	accesslevel INT UNSIGNED NOT NULL);

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
    VALUES ( 'User');

INSERT INTO access(naam)
    VALUES ( '5');

INSERT INTO access(naam)
    VALUES ( '6');

INSERT INTO access(naam)
    VALUES ( 'Admin');

insert into plaas (naam) values ('ROM');
insert into plaas (naam) values ('DB');
insert into gewas (naam) values ('Uie');
insert into gewas (naam) values ('Aartappels');
insert into gewas (naam) values ('Wortels');
insert into gewas (naam) values ('Beet');

insert into users (naam,pwd,accesslevel) values ('admin','admin',7);