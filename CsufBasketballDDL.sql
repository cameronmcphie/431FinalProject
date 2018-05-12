drop database if exists CsufBasketball;
create database if not exists CsufBasketball;

drop user if exists 'Manager';
grant select, insert, update, execute on CsufBasketBall.* to 'Manager' identified by 'withheld';

drop user if exists 'User';
grant select, update, execute on CsufBasketBall.* to 'User' identified by 'withheld';

USE CsufBasketball;

CREATE TABLE Person
(
  Id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  FirstName VARCHAR(30),
  LastName VARCHAR(30),
  Street VARCHAR(250),
  City VARCHAR(100),
  Country VARCHAR(100),
  Zipcode CHAR(10),
  Email VARCHAR(100)

  CHECK (ZipCode REGEXP '(?!0{5})(?!9{5})\\d{5}(-(?!0{4})(?!9{4})\\d{4})?')
);


CREATE TABLE User
(
  PersonId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Username VARCHAR(100) NOT NULL,
  Password VARCHAR(100) NOT NULL,
  Role TINYINT(1) NOT NULL,

  FOREIGN KEY (PersonId) REFERENCES Person(Id),

  UNIQUE(Username, Password)
);

CREATE TABLE Player
(
  PersonId INTEGER UNSIGNED NOT NULL PRIMARY KEY,
  Active BOOLEAN NOT NULL,
  Height TINYINT(3) DEFAULT 0,
  Weight TINYINT(3) DEFAULT 0,
  InactiveNote VARCHAR(300),
  LastModifiedBy INTEGER UNSIGNED NOT NULL,

  FOREIGN KEY (PersonId) REFERENCES Person(Id)
);


CREATE TABLE Games
(
  Id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  WonGame BOOLEAN NOT NULL,
  OpposingTeam VARCHAR(100) NOT NULL,
  OpposingTeamScore TINYINT(3) NOT NULL,
  LastUpdatedBy INTEGER NOT NULL
);

CREATE TABLE StatsPerGame
(
  PlayerId INTEGER UNSIGNED NOT NULL,
  GameId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  TimeMin TINYINT(2)  UNSIGNED DEFAULT 0,
  TimeSec TINYINT(2) UNSIGNED DEFAULT 0,
  Points TINYINT UNSIGNED DEFAULT 0,
  Assists TINYINT UNSIGNED DEFAULT 0,
  Rebounds TINYINT UNSIGNED DEFAULT 0,

  FOREIGN KEY (PlayerId) REFERENCES Player(PersonId),
  FOREIGN KEY (GameId) REFERENCES Games(Id),

  CHECK((TimeMin < 40 AND TimeSec < 60) OR
        (TimeMin = 40 AND TimeSec = 0 ))
);
