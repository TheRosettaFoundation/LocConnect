CREATE TABLE IF NOT EXISTS `Demo` 
(
    `Job` TEXT,
    `Com` TEXT,
    `FileData` TEXT,
    `Status` TEXT,
    `Feedback` TEXT,
    `Output` TEXT,
    `WOrder` INTEGER,
    `PickDate` DATETIME,
    `UpdatedDate` DATETIME,
    `OutputDate` DATETIME
);

CREATE TABLE IF NOT EXISTS `Project` 
(
    `ID` TEXT,
    `Desc` TEXT,
    `CreateDate` DATETIME,
    `FinishDate` DATETIME,
    `MaxSteps` INTEGER,
    `PName` TEXT,
    `Output` TEXT,
    `CurrentStep` INTEGER,
    `filename` CHAR(50)
);

CREATE TABLE IF NOT EXISTS `ResourceMetadata` 
(
    `ResourceID` TEXT NOT NULL,
    `Attribute` TEXT,
    `Value` TEXT
);

CREATE TABLE IF NOT EXISTS `Resources` 
(
    `ResourceID` TEXT NOT NULL,
    `Type` TEXT,
    `Description` TEXT,
    `File` TEXT,
    `Filename` TEXT
);

