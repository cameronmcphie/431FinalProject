drop database if exists CsufBasketball;
create database if not exists CsufBasketball;

drop user if exists 'phpWebEngine';
grant select, insert, delete, update, execute on CsufBasketBall.* to 'phpWebEngine' identified by 'withheld';

USE CsufBasketball;

CREATE TABLE Staff
(
  StaffId INTEGER NOT NULL,
  Password VARCHAR(100) NOT NULL,
  FirstName VARCHAR(30) NOT NULL,
  LastName VARCHAR(30) NOT NULL,

  UNIQUE(StaffId, Password)
);

CREATE TABLE Players
(
  PlayerId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  FirstName VARCHAR(30),
  LastName VARCHAR(30),
  Street VARCHAR(250),
  City VARCHAR(100),
  Country VARCHAR(100),
  Zipcode CHAR(10),
  Active BOOLEAN NOT NULL,

  CHECK (ZipCode REGEXP '(?!0{5})(?!9{5})\\d{5}(-(?!0{4})(?!9{4})\\d{4})?')
);

CREATE TABLE Games
(
  GameId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  WonGame BOOLEAN NOT NULL,
  OpposingTeam VARCHAR(50) NOT NULL,
  OpposingTeamScore TINYINT(3) NOT NULL,
  LastUpdatedBy INTEGER NOT NULL,

  FOREIGN KEY (LastUpdatedBy) REFERENCES Staff(StaffId)
);

CREATE TABLE StatsPerGame (
  StatId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Player INTEGER UNSIGNED NOT NULL,
  Game INTEGER UNSIGNED NOT NULL,
  Playertimemin TINYINT(2)  UNSIGNED DEFAULT 0,
  Playertimesec TINYINT(2) UNSIGNED DEFAULT 0,
  Points TINYINT UNSIGNED DEFAULT 0,
  Assists TINYINT UNSIGNED DEFAULT 0,
  Rebounds TINYINT UNSIGNED DEFAULT 0,

  FOREIGN KEY (Player) REFERENCES Players(PlayerId),
  FOREIGN KEY (Game) REFERENCES Games(GameId),

  CHECK((PlayingTimeMin < 40 AND PlayingTimeSec < 60) OR
        (PlayingTimeMin = 40 AND PlayingTimeSec = 0 ))
);
