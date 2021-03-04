--un comment on first run
--CREATE database WildeKlawerTydkaarte;

--create new tables
DROP TABLE IF EXISTS plaas;
CREATE TABLE plaas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));

insert into plaas (naam) values ('ROM');
insert into plaas (naam) values ('DB');

DROP TABLE IF EXISTS gewas;
CREATE TABLE gewas ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));
	
insert into gewas (naam) values ('Uie');
insert into gewas (naam) values ('Aartappels');
insert into gewas (naam) values ('Wortels');
insert into gewas (naam) values ('Beet');

DROP TABLE IF EXISTS spilpunt;
CREATE TABLE spilpunt ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254),
	farm_id INT UNSIGNED NOT NULL);

insert into spilpunt (farm_id,naam) values (1,'T1');
insert into spilpunt (farm_id,naam) values (1,'T2');

DROP TABLE IF EXISTS task;
CREATE TABLE task ( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	afkorting VARCHAR(254));
insert into task (naam) values ('Algemeen');
insert into task (naam) values ('Oes');
insert into task (naam) values ('Plant');
insert into task (naam) values ('Skoffel');

DROP TABLE IF EXISTS users;
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

DROP TABLE IF EXISTS workers;
CREATE TABLE workers( 
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	naam VARCHAR(254) NOT NULL,
	van VARCHAR(254) NOT NULL,
	area VARCHAR(254),
	skof VARCHAR(254) NOT NULL,
  img_data LONGTEXT,
  contract_end DATE NOT NULL,
	CN VARCHAR(50) NOT NULL);

DROP TABLE IF EXISTS access;
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

DROP TABLE IF EXISTS worklog;
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

DROP TABLE IF EXISTS clocklog;
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

DROP VIEW IF EXISTS vWorkLog;
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


DROP VIEW IF EXISTS vclocklogOut;
CREATE VIEW vclocklogOut AS
Select
  clocklog.id,
  workers.naam,
  workers.van,
  workers.CN,
  users.naam As managerNaam,
  workers.van As managerVan,
  clocklog.logDate,
  clocklog.logTime,
  plaas.naam As plaasNaam,
  spilpunt.naam As spilpuntNaam,
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
  clocklog.clockType = 1;


DROP VIEW IF EXISTS vclocklogIn;
CREATE VIEW vclocklogIn AS
Select
  clocklog.id,
  workers.naam,
  workers.van,
  workers.CN,
  users.naam As managerNaam,
  users.van As managerVan,
  clocklog.logDate,
  clocklog.logTime,
  plaas.naam As plaasNaam,
  spilpunt.naam As spilpuntNaam,
  task.naam As taakNaam,
  gewas.naam as gewas,
  'IN' As clockType
From
  clocklog left Join
  plaas On clocklog.farm_id = plaas.id left Join
  spilpunt On clocklog.spry_id = spilpunt.id left Join
  task On clocklog.task_id = task.id left Join
  users On clocklog.user_id = users.id left Join
  workers On clocklog.worker_id = workers.id left Join
  gewas on clocklog.produce_id = gewas.id
Where
  clocklog.clockType = 0;

DROP VIEW IF EXISTS vclocklogNotOut;
CREATE VIEW vclocklogNotOut AS
Select
  clocklog.id As Max_id,
  workers.naam,
  workers.van,
  workers.CN,
  users.naam As managerNaam,
  users.van As managerVan,
  clocklog.logDate,
  clocklog.logTime,
  plaas.naam As plaasNaam,
  spilpunt.naam As spilpuntNaam,
  task.naam As taakNaam,
  clocklog.clockType
From
  clocklog Left Join
  plaas On clocklog.farm_id = plaas.id Left Join
  spilpunt On clocklog.spry_id = spilpunt.id Left Join
  task On clocklog.task_id = task.id Left Join
  users On clocklog.user_id = users.id Left Join
  workers On clocklog.worker_id = workers.id
Order by clocklog.id DESC
limit 1;

DROP VIEW IF EXISTS vclocklogInOut;
CREATE VIEW vclocklogInOut AS
Select
  vclocklogIn.logDate As inDate,
  vclocklogIn.logTime As inTime,
  (Select
    vclocklogOut.logDate
  From
    vclocklogOut
  Where
    vclocklogOut.id > vclocklogIn.id
  Limit 1) As outDate,
  (Select
    vclocklogOut.logTime
  From
    vclocklogOut
  Where
    vclocklogOut.id > vclocklogIn.id
  Limit 1) As outTime,
  vclocklogIn.naam,
  vclocklogIn.van,
  vclocklogIn.CN,
  vclocklogIn.managerNaam,
  vclocklogIn.managerVan,
  vclocklogIn.plaasNaam,
  vclocklogIn.spilpuntNaam,
  vclocklogIn.taakNaam,
  vclocklogIn.gewas
From
  vclocklogIn;

DROP VIEW IF EXISTS vworktimecalc;
CREATE VIEW vworktimecalc AS
Select
  TimeDiff(vclocklogInOut.outTime,vclocklogInOut.inTime) As MinutesOnClock,
  vclocklogInOut.inDate,
  vclocklogInOut.inTime,
  vclocklogInOut.outDate,
  vclocklogInOut.outTime,
  vclocklogInOut.naam,
  vclocklogInOut.van,
  vclocklogInOut.CN,
  vclocklogInOut.managerNaam,
  vclocklogInOut.managerVan,
  vclocklogInOut.plaasNaam,
  vclocklogInOut.spilpuntNaam,
  vclocklogInOut.taakNaam,
  vclocklogInOut.gewas
From
  vclocklogInOut;

DROP VIEW IF EXISTS vshifttotal;
CREATE VIEW vshifttotal AS
Select
  Sec_To_Time(Sum(Time_To_Sec(vworktimecalc.MinutesOnClock))) As TimeWorked,
  vworktimecalc.outDate as Date,
  vworktimecalc.naam,
  vworktimecalc.van,
  vworktimecalc.CN,
  vworktimecalc.managerNaam,
  vworktimecalc.managerVan
From
  vworktimecalc
GROUP BY vworktimecalc.outDate,vworktimecalc.naam,vworktimecalc.van,vworktimecalc.CN;