PRAGMA foreign_keys=OFF; 


DROP TABLE IF EXISTS contato;

CREATE TABLE contato (
	id_contato  INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	nome	    TEXT NOT NULL,
	ddi	        VARCHAR(4) NOT NULL DEFAULT '+55',
	ddd	        VARCHAR(2) NOT NULL,
	celular	    VARCHAR(9) NOT NULL,
	st_whatsapp	VARCHAR(2) DEFAULT 'S',
	avisado	    VARCHAR(2) DEFAULT 'N',
	dtInclusao  datetime NOT NULL, 
    dtAlteracao datetime,
    dtExclusao  datetime
);

DROP TABLE IF EXISTS mensagem;

CREATE TABLE mensagem (
	id_mensagem	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	mensagem	TEXT NOT NULL,
	dtInclusao  datetime NOT NULL, 
    dtAlteracao datetime,
    dtExclusao  datetime
);
