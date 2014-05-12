CREATE TABLE crm.rsc_import (
  importfilename VARCHAR(100) DEFAULT NULL,
  date VARCHAR(45) DEFAULT NULL,
  total INT(11) DEFAULT NULL,
  newleads INT(11) DEFAULT NULL,
  originalfilename VARCHAR(100) DEFAULT NULL,
  source VARCHAR(45) DEFAULT NULL,
  badimport TINYINT(1) DEFAULT 0
)
ENGINE = MYISAM
AVG_ROW_LENGTH = 97
CHARACTER SET utf8
COLLATE utf8_unicode_ci;