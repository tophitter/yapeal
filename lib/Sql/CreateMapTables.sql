CREATE TABLE "{database}"."{table_prefix}mapFacWarSystems" (
    "contested"             ENUM('False','True') NOT NULL,
    "occupyingFactionID"    BIGINT(20) UNSIGNED DEFAULT NULL,
    "occupyingFactionName"  CHAR(50)            DEFAULT NULL,
    "owningFactionID"       BIGINT(20) UNSIGNED DEFAULT NULL,
    "owningFactionName"     CHAR(50)            DEFAULT NULL,
    "solarSystemID"         BIGINT(20) UNSIGNED  NOT NULL,
    "solarSystemName"       CHAR(50)             NOT NULL,
    "victoryPoints"         BIGINT(20) UNSIGNED  NOT NULL,
    "victoryPointThreshold" BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY ("solarSystemID")
)
ENGINE ={ engine}
COLLATE utf8_unicode_ci;
CREATE TABLE "{database}"."{table_prefix}mapJumps" (
    "shipJumps"     BIGINT(20) UNSIGNED NOT NULL,
    "solarSystemID" BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY ("solarSystemID")
)
ENGINE ={ engine}
COLLATE utf8_unicode_ci;
CREATE TABLE "{database}"."{table_prefix}mapKills" (
    "factionKills"  BIGINT(20) UNSIGNED NOT NULL,
    "podKills"      BIGINT(20) UNSIGNED NOT NULL,
    "shipKills"     BIGINT(20) UNSIGNED NOT NULL,
    "solarSystemID" BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY ("solarSystemID")
)
ENGINE ={ engine}
COLLATE utf8_unicode_ci;
CREATE TABLE "{database}"."{table_prefix}mapSovereignty" (
    "allianceID"      BIGINT(20) UNSIGNED NOT NULL,
    "corporationID"   BIGINT(20) UNSIGNED NOT NULL,
    "factionID"       BIGINT(20) UNSIGNED NOT NULL,
    "solarSystemID"   BIGINT(20) UNSIGNED NOT NULL,
    "solarSystemName" CHAR(50)            NOT NULL,
    PRIMARY KEY ("solarSystemID")
)
ENGINE ={ engine}
COLLATE utf8_unicode_ci;
