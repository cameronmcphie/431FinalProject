drop database if exists CsufBasketball;
create database if not exists CsufBasketball;

drop user if exists 'Manager';
grant select, insert, update, execute on CsufBasketball.* to 'Manager' identified by 'withheld';

drop user if exists 'User';
grant select, update, execute on CsufBasketball.* to 'User' identified by 'withheld';

  -- GRANT SELECT, INSERT, DELETE, UPDATE
  -- ON CsufBasketball.Player, CsufBasketball.StatsPerGame

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
  INDEX  (Name_Last),
  UNIQUE (Name_Last, Name_First)
);

INSERT INTO Person VALUES
('100', 'Donald',               'Duck',    '1313 S. Harbor Blvd.',    'Anaheim',            'CA',            'USA',     '92808-3232', donald@mail.com),
('101', 'Daisy',                'Duck',    '1180 Seven Seas Dr.',     'Lake Buena Vista',   'FL',            'USA',     '32830', daisy@mail.com),
('102', 'Mickey',               'Mouse',   '1313 S. Harbor Blvd.',    'Anaheim',            'CA',            'USA',     '92808-3232', mickey@mail.com),
('103', 'Pluto',                'Dog',     '1313 S. Harbor Blvd.',    'Anaheim',            'CA',            'USA',     '92808-3232' pluto@mail.com),
('104', 'Della',                'Duck',    '77700 Boulevard du Parc', 'Coupvray',           'Disney Paris',  'France',  NULL, della@mail.com);



CREATE TABLE Users
(
  PersonId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Username VARCHAR(16) NOT NULL,
  Password VARCHAR(100) NOT NULL,
  Role TINYINT DEFAULT 0,

  FOREIGN KEY (PersonId) REFERENCES Person(Id),

  UNIQUE(Username, Password)
);

INSERT INTO Users VALUES
('101', 'csuffan1', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0'),
('102', 'eaglesfan', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '1');

CREATE TABLE Player
(
  PersonId INTEGER UNSIGNED NOT NULL PRIMARY KEY,
  Height INTEGER DEFAULT 0,
  Weight INTEGER DEFAULT 0,
  Active BOOLEAN DEFAULT True,
  InactiveNote VARCHAR(300),
  LastModifiedBy INTEGER UNSIGNED NOT NULL,

  FOREIGN KEY (PersonId) REFERENCES Person(Id)
);

INSERT INTO Player VALUES
('1', '5.10', '180', '0', 'disabled', '102'),
('2', '5.8', '195', '1', '', '101'),
('3', '6.4', '220', '1', '', '101'),
('4', '6.5', '230', '1', '', '101'),
('5', '6.0', '200', '1', '', '101'),
('6', '6.3', '188', '1', '', '101'),
('7', '6.2', '202', '1', '', '101');



CREATE TABLE Games
(
  Id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  WonGame BOOLEAN NOT NULL,
  OpposingTeam VARCHAR(100) NOT NULL,
  OpposingTeamScore TINYINT NOT NULL,
  LastUpdatedBy INTEGER NOT NULL
);

INSERT INTO Games VALUES
('4', '2', 'Eagles', '56', '02'),
('5', '3', 'Falcons', '44', '01'),
('6', '6', 'Hawks', '67', '04'),
('7', '1', 'Knights', '59', '02'),
('8', '4', 'Seaguls', '77', '01');

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

INSERT INTO StatsPerGame VALUES
('1', '4', '100', '30', '12', '47', '01'),
('2', '4', '102', '13', '22', '13', '01'),
('3', '4', '103', '10', '60', '18', '02'),
('4', '4', '107', '02', '45', '09', '01'),
('5', '4', '102', '15', '39', '26', '03'),
('6', '4', '100', '29', '47', '27', '09'),
('7', '4', '90', '30', '55', '10', '04');
