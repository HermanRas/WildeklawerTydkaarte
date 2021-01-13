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

DROP TABLE spilpunt;
CREATE TABLE spilpunt ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254),
	farm_id INT UNSIGNED NOT NULL);

insert into spilpunt (farm_id,naam) values (1,'T1');
insert into spilpunt (farm_id,naam) values (1,'T2');

DROP TABLE task;
CREATE TABLE task ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));
insert into task (naam) values ('Algemeen');
insert into task (naam) values ('Oes');
insert into task (naam) values ('Plant');
insert into task (naam) values ('Skoffel');

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
  spilpunt.naam As spilpunt,
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


DROP VIEW vclocklogOut;
CREATE VIEW vclocklogOut AS
Select
  clocklog.id,
  workers.naam,
  workers.van,
  workers.CN,
  users.naam As managerNaam,
  workers.van As managerVen,
  clocklog.logDate,
  clocklog.logTime,
  plaas.naam As plaasNaam,
  spilpunt.naam As sipluntNaam,
  task.naam As taakNaam,
  'UIT' As clockType
From
  clocklog left Join
  plaas On clocklog.farm_id = plaas.id left Join
  spilpunt On clocklog.spry_id = spilpunt.id left Join
  task On clocklog.task_id = task.id left Join
  users On clocklog.user_id = users.id left Join
  workers On clocklog.worker_id = workers.id
Where
  clocklog.clockType = 1


DROP VIEW vclocklogIn;
CREATE VIEW vclocklogIn AS
Select
  clocklog.id,
  workers.naam,
  workers.van,
  workers.CN,
  users.naam As managerNaam,
  workers.van As managerVen,
  clocklog.logDate,
  clocklog.logTime,
  plaas.naam As plaasNaam,
  spilpunt.naam As sipluntNaam,
  task.naam As taakNaam,
  'IN' As clockType
From
  clocklog left Join
  plaas On clocklog.farm_id = plaas.id left Join
  spilpunt On clocklog.spry_id = spilpunt.id left Join
  task On clocklog.task_id = task.id left Join
  users On clocklog.user_id = users.id left Join
  workers On clocklog.worker_id = workers.id
Where
  clocklog.clockType = 0

DROP VIEW vclocklogNotOut;
CREATE VIEW vclocklogNotOut AS
Select
  Max(clocklog.id) As Max_id,
  workers.naam,
  workers.van,
  workers.CN,
  users.naam As managerNaam,
  workers.van As managerVen,
  clocklog.logDate,
  clocklog.logTime,
  plaas.naam As plaasNaam,
  spilpunt.naam As sipluntNaam,
  task.naam As taakNaam,
  clocklog.clockType
From
  clocklog Left Join
  plaas On clocklog.farm_id = plaas.id Left Join
  spilpunt On clocklog.spry_id = spilpunt.id Left Join
  task On clocklog.task_id = task.id Left Join
  users On clocklog.user_id = users.id Left Join
  workers On clocklog.worker_id = workers.id

DROP VIEW vclocklogInOut;
CREATE VIEW vclocklogInOut AS
Select
  vclocklogin.logDate As inDate,
  vclocklogin.logTime As inTime,
  (Select
    vclocklogout.logDate
  From
    vclocklogout
  Where
    vclocklogout.id > vclocklogin.id
  Limit 1) As outDate,
  (Select
    vclocklogout.logTime
  From
    vclocklogout
  Where
    vclocklogout.id > vclocklogin.id
  Limit 1) As outTime,
  vclocklogin.naam,
  vclocklogin.van,
  vclocklogin.CN,
  vclocklogin.managerNaam,
  vclocklogin.managerVen,
  vclocklogin.plaasNaam,
  vclocklogin.sipluntNaam,
  vclocklogin.taakNaam
From
  vclocklogin

DROP VIEW vworktimecalc;
CREATE VIEW vworktimecalc AS
Select
  TimeDiff(vclockloginout.inTime, vclockloginout.outTime) As MinutesOnClock,
  vclockloginout.inDate,
  vclockloginout.inTime,
  vclockloginout.outDate,
  vclockloginout.outTime,
  vclockloginout.naam,
  vclockloginout.van,
  vclockloginout.CN,
  vclockloginout.managerNaam,
  vclockloginout.managerVen,
  vclockloginout.plaasNaam,
  vclockloginout.sipluntNaam,
  vclockloginout.taakNaam
From
  vclockloginout

DROP VIEW vshifttotal;
CREATE VIEW vshifttotal AS
Select
  Sec_To_Time(Sum(Time_To_Sec(wildeklawertydkaarte.vworktimecalc.MinutesOnClock))) As TimeWorked,
  vworktimecalc.outDate as Date,
  vworktimecalc.naam,
  vworktimecalc.van,
  vworktimecalc.CN,
  vworktimecalc.managerNaam,
  vworktimecalc.managerVen
From
  vworktimecalc