--
-- ClickTrack Module SQLite Database for Phire CMS 2.0
--

--  --------------------------------------------------------

--
-- Set database encoding
--

PRAGMA encoding = "UTF-8";
PRAGMA foreign_keys = ON;

-- --------------------------------------------------------

--
-- Table structure for table "clicks"
--

CREATE TABLE IF NOT EXISTS "[{prefix}]clicks" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "uri" varchar NOT NULL,
  "type" varchar NOT NULL,
  "clicks" integer,
  "ips" text,
  UNIQUE ("id"),
  UNIQUE ("uri")
) ;

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('[{prefix}]clicks', 21000);

-- --------------------------------------------------------
