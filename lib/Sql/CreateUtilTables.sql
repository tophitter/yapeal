CREATE TABLE "{database}"."{table_prefix}utilCachedUntil" (
    "apiName"     CHAR(32)            NOT NULL,
    "expires"     DATETIME            NOT NULL,
    "ownerID"     BIGINT(20) UNSIGNED NOT NULL,
    "sectionName" CHAR(8)             NOT NULL,
    PRIMARY KEY ("apiName","ownerID")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
CREATE TABLE "{database}"."{table_prefix}utilDatabaseVersion" (
    "version" CHAR(12) NOT NULL,
    PRIMARY KEY ("version")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
INSERT INTO "{database}"."{table_prefix}utilDatabaseVersion" ("version")
VALUES
    ('201506131923');
CREATE TABLE "{database}"."{table_prefix}utilEveApi" (
    "active"      TINYINT(1)          NOT NULL,
    "apiName"     CHAR(32)            NOT NULL,
    "interval"    INT(10) UNSIGNED    NOT NULL,
    "mask"        BIGINT(20) UNSIGNED NOT NULL,
    "sectionName" CHAR(8)             NOT NULL,
    PRIMARY KEY ("apiName","sectionName")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
START TRANSACTION;
INSERT INTO "{database}"."{table_prefix}utilEveApi" ("sectionName","apiName","mask","interval","active")
VALUES
    ('account','AccountStatus',33554432,3600,1),
    ('account','YapealCorporationSheet',0,21600,1),
    ('api','CallList',1,86400,1),
    ('char','AccountBalance',1,900,1),
    ('char','AssetList',2,21600,1),
    ('char','Blueprints',2,43200,1),
    ('char','CalendarEventAttendees',4,3600,1),
    ('char','CharacterSheet',8,3600,1),
    ('char','ContactList',16,900,1),
    ('char','ContactNotifications',32,21600,1),
    ('char','Contracts',67108864,900,1),
    ('char','FacWarStats',64,3600,1),
    ('char','IndustryJobs',128,900,1),
    ('char','IndustryJobsHistory',128,21600,1),
    ('char','KillMails',256,1800,1),
    ('char','Locations',134217728,3600,1),
    ('char','MailBodies',512,1800,1),
    ('char','MailingLists',1024,21600,1),
    ('char','MailMessages',2048,1800,1),
    ('char','MarketOrders',4096,3600,1),
    ('char','Medals',8192,3600,1),
    ('char','Notifications',16384,1800,1),
    ('char','NotificationTexts',32768,1800,1),
    ('char','Research',65536,900,1),
    ('char','SkillInTraining',131072,300,1),
    ('char','SkillQueue',262144,900,1),
    ('char','Standings',524288,3600,1),
    ('char','UpcomingCalendarEvents',1048576,900,1),
    ('char','WalletJournal',2097152,1800,1),
    ('char','WalletTransactions',4194304,3600,1),
    ('corp','AccountBalance',1,900,1),
    ('corp','AssetList',2,21600,1),
    ('corp','Blueprints',2,43200,1),
    ('corp','ContactList',16,900,1),
    ('corp','ContainerLog',32,3600,1),
    ('corp','Contracts',8388608,900,1),
    ('corp','CorporationSheet',8,21600,1),
    ('corp','Facilities',64,900,1),
    ('corp','FacWarStats',64,3600,1),
    ('corp','IndustryJobs',128,900,1),
    ('corp','IndustryJobsHistory',128,21600,1),
    ('corp','KillMails',256,1800,1),
    ('corp','Locations',16777216,3600,1),
    ('corp','MarketOrders',4096,3600,1),
    ('corp','Medals',8192,3600,1),
    ('corp','MemberMedals',4,3600,1),
    ('corp','MemberSecurity',512,3600,1),
    ('corp','MemberSecurityLog',1024,3600,1),
    ('corp','MemberTrackingExtended',33554432,21600,1),
    ('corp','MemberTrackingLimited',2048,3600,1),
    ('corp','OutpostList',16384,3600,1),
    ('corp','OutpostServiceDetail',32768,3600,1),
    ('corp','Shareholders',65536,3600,1),
    ('corp','Standings',262144,3600,1),
    ('corp','StarbaseDetail',131072,3600,1),
    ('corp','StarbaseList',524288,3600,1),
    ('corp','Titles',4194304,3600,1),
    ('corp','WalletJournal',1048576,1800,1),
    ('corp','WalletTransactions',2097152,3600,1),
    ('eve','AllianceList',1,3600,1),
    ('eve','CertificateTree',2,86400,1),
    ('eve','CharacterID',4,3600,1),
    ('eve','CharacterInfo',0,3600,0),
    ('eve','CharacterInfoPrivate',16777216,3600,1),
    ('eve','CharacterInfoPublic',8388608,3600,1),
    ('eve','CharacterName',8,3600,1),
    ('eve','ConquerableStationList',16,3600,1),
    ('eve','ErrorList',32,86400,1),
    ('eve','FacWarStats',64,3600,1),
    ('eve','FacWarTopStats',128,3600,1),
    ('eve','RefTypes',256,86400,1),
    ('eve','SkillTree',512,86400,1),
    ('eve','YapealCorporationSheet',0,86400,0),
    ('map','FacWarSystems',1,3600,1),
    ('map','Jumps',2,3600,1),
    ('map','Kills',4,3600,1),
    ('map','Sovereignty',8,3600,1),
    ('server','ServerStatus',1,300,1);
COMMIT;
CREATE TABLE "{database}"."{table_prefix}utilRegisteredKey" (
    "active"        TINYINT(1)          DEFAULT NULL,
    "activeAPIMask" BIGINT(20) UNSIGNED DEFAULT NULL,
    "keyID"         BIGINT(20) UNSIGNED NOT NULL,
    "vCode"         VARCHAR(64)         NOT NULL,
    PRIMARY KEY ("keyID")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
INSERT INTO "{database}"."{table_prefix}utilRegisteredKey" ("activeAPIMask","active","keyID","vCode")
VALUES
    (8388608,1,1156,'abc123');
CREATE TABLE "{database}"."{table_prefix}utilRegisteredUploader" (
    "active"              TINYINT(1)   DEFAULT NULL,
    "key"                 VARCHAR(255) DEFAULT NULL,
    "ownerID"             BIGINT(20) UNSIGNED NOT NULL,
    "uploadDestinationID" BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY ("ownerID","uploadDestinationID")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
CREATE TABLE "{database}"."{table_prefix}utilUploadDestination" (
    "active"              TINYINT(1)   DEFAULT NULL,
    "name"                VARCHAR(25)  DEFAULT NULL,
    "uploadDestinationID" BIGINT(20) UNSIGNED NOT NULL,
    "url"                 VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY ("uploadDestinationID")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
CREATE TABLE "{database}"."{table_prefix}utilXmlCache" (
    "apiName"     CHAR(32)  NOT NULL,
    "hash"        CHAR(40)  NOT NULL,
    "modified"    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    "sectionName" CHAR(8)   NOT NULL,
    "xml"         LONGTEXT,
    PRIMARY KEY ("hash")
)
ENGINE = { engine}
COLLATE utf8_unicode_ci;
ALTER TABLE "{database}"."{table_prefix}utilXmlCache" ADD INDEX "utilXmlCache1" ("sectionName");
ALTER TABLE "{database}"."{table_prefix}utilXmlCache" ADD INDEX "utilXmlCache2" ("apiName");
