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
insert into Task (naam) values ('General');
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

DROP TABLE worklog;
CREATE TABLE worklog( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	worker_id INT UNSIGNED NOT NULL,
	farm_id INT UNSIGNED NOT NULL,
	produce_id INT UNSIGNED NOT NULL,
	spry_id INT UNSIGNED NOT NULL,
	task_id INT UNSIGNED NOT NULL,
	crates INT NOT NULL,
	logDate DATE NOT NULL,
	logTime TIME NOT NULL,
	Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP );

DROP TABLE clocklog;
CREATE TABLE clocklog( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	worker_id INT UNSIGNED NOT NULL,
	task_id INT UNSIGNED,
	farm_id INT UNSIGNED NOT NULL,
	spry_id INT UNSIGNED NOT NULL,
	clockType BIT NOT NULL,
	logDate DATE NOT NULL,
	logTime TIME NOT NULL,
	Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP );

DROP VIEW vWorkLog;
CREATE VIEW vWorkLog AS
Select
  worklog.id,
  workers.naam,
  workers.van,
  workers.CN,
  plaas.naam As plaas,
  gewas.naam As gewas,
  spilpunt.naam As Spilpunt,
  task.naam As taak,
  worklog.crates,
  worklog.logDate,
  worklog.logTime,
  worklog.Created,
  users.naam As Bestuurder_naam,
  users.van As Bestuurder_Van
From
  worklog Inner Join
  spilpunt On spilpunt.id = worklog.spry_id Left Join
  users On users.id = worklog.user_id Left Join
  task On task.id = worklog.task_id Left Join
  plaas On plaas.id = worklog.farm_id Left Join
  gewas On gewas.id = worklog.produce_id Left Join
  workers On workers.id = worklog.worker_id;



