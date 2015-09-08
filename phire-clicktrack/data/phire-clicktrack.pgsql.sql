--
-- ClickTrack Module PostgreSQL Database for Phire CMS 2.0
--

-- --------------------------------------------------------

--
-- Table structure for table "clicks"
--

CREATE SEQUENCE click_id_seq START 21001;

CREATE TABLE IF NOT EXISTS "[{prefix}]clicks" (
  "id" integer NOT NULL DEFAULT nextval('search_id_seq'),
  "uri" varchar(255) NOT NULL,
  "type" varchar(255) NOT NULL,
  "clicks" integer,
  "ips" text,
  PRIMARY KEY ("id")
) ;

ALTER SEQUENCE click_id_seq OWNED BY "[{prefix}]clicks"."id";

-- --------------------------------------------------------
