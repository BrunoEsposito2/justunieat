-- *********************************************
-- * Standard SQL generation
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.0
-- * Generator date: Sep  6 2018
-- * Generation date: Sat Jan 12 15:43:16 2019
-- * LUN file: C:\Users\Gianfree\Google Drive\Universit√†\3 ANNO\1.Tecnologie Web\PROGETTO\REPO\webproject\db\TEC.WEB.lun
-- * Schema: TEC_WEB_LOGIC/SQL
-- *********************************************


-- Database Section
-- ________________
drop DATABASE JUST_DATABASE;
create database JUST_DATABASE;


-- DBSpace Section
-- _______________


-- Tables Section
-- _____________

create table CATEGORIA_RISTORANTE (
     Nome varchar(30) NOT NULL,
	 ID_CAT INT AUTO_INCREMENT NOT NULL,
	 CONSTRAINT ID_CAT PRIMARY key (ID_CAT));

create table CATEGORIE (
     ID_FORNITORE INT NOT NULL,
     ID_CAT INT NOT NULL,
     constraint ID_CATEGORIE_ID primary key (ID_FORNITORE, ID_CAT));

create table FORNITORE (
     Nome varchar(30) not null,
     Cognome varchar(30) not null,
     Ristorante varchar(30) not null,
     Cellulare varchar(30) not null,
     Partita_IVA varchar(30) not null,
     Email varchar(50) not null,
     Valutazione varchar(10),
     ID_FORNITORE INT NOT NULL AUTO_INCREMENT,
     constraint ID_FORNITORE_ID primary key (ID_FORNITORE));

create table MENU (
     ID_FORNITORE INT NOT NULL,
     ID_MENU INT NOT NULL AUTO_INCREMENT,
     constraint ID_MENU unique (ID_MENU));

create table MESSAGGIO (
     Testo varchar(500) not null,
     Data varchar(30) not null,
	Titolo varchar(30),
     Orario varchar(30) not null,
     ID_MESS INT NOT NULL AUTO_INCREMENT,
     ID_USER INT NOT NULL,
     ID_RISTORANTE INT NOT NULL,
     constraint ID_MESSAGGIO_ID primary key (ID_MESS));

create table ORDINE (
     ID_ORDINE INT NOT NULL AUTO_INCREMENT,
     Orario_Richiesto varchar(30) not null,
     Stato varchar(30) not null,
     ID_USER INT NOT NULL,
     ID_RESTURANT INT NOT NULL,
     constraint ID_ORDINE_ID primary key (ID_ORDINE));

create table PIETANZA (
     Nome varchar(30) not null,
     Descrizione varchar(150) not null,
     Valutazione varchar(10) not null,
     Prezzo varchar(30) not null,
     Vegetariano bit not null,
     Piccante bit not null,
     Tipologia varchar(30) not null,
     ID_MENU INT NOT NULL,
     constraint ID_PIETANZA_ID primary key (Nome));

create table TIPOLOGIA_PIETANZA (
     Nome_Tipologia varchar(30) NOT NULL,
     constraint ID_TIPOLOGIA_PIETANZA_ID primary key(Nome_Tipologia));

create table PIETANZA_NEL_ORDINE (
	Nome varchar(30) NOT NULL,
	ID_ORDINE INT NOT NULL,
	Quantit‡ INT DEFAULT '1',
	constraint ID primary key (Nome, ID_ORDINE);

create table UTENTE (
     Nome varchar(30) not null,
     Cognome varchar(30) not null,
     Email varchar(50) not null,
     Password varchar(50) not null,
     Salt char(128) NOT NULL,
     ID_USER INT NOT NULL AUTO_INCREMENT,
	Cellulare varchar(30) not null,
     constraint ID_UTENTE_ID primary key (ID_USER));

create table LOGIN_ATTEMPS (
	ID_USER INT NOT NULL,
	TIME varchar(30) not null);


-- Constraints Section
-- ___________________

alter table CATEGORIE add constraint REF_CATEG_FORNI
     foreign key (ID_FORNITORE)
     references FORNITORE (ID_FORNITORE);

alter table CATEGORIE add constraint REF_CATEG_CATEG_FK
     foreign key (ID_CAT)
     references CATEGORIA_RISTORANTE (ID_CAT);

alter table FORNITORE add constraint ID_FORNITORE_CHK
     check(exists(select * from MENU
                  where MENU.ID_FORNITORE = ID_FORNITORE));

alter table MENU add constraint ID_MENU_FORNI_CHK
     check(exists(select * from PIETANZA
                  where PIETANZA.ID_MENU = ID_FORNITORE));

alter table MENU add constraint ID_MENU_FORNI_FK
     foreign key (ID_FORNITORE)
     references FORNITORE (ID_FORNITORE);

alter table MESSAGGIO add constraint REF_MESSA_UTENT_FK
     foreign key (ID_USER)
     references UTENTE (ID_USER);

alter table MESSAGGIO add constraint REF_MESSA_FORNI_FK
     foreign key (ID_RISTORANTE)
     references FORNITORE (ID_FORNITORE);

alter table ORDINE add constraint REF_ORDIN_UTENT_FK
     foreign key (ID_USER)
     references UTENTE (ID_USER);

alter table ORDINE add constraint REF_ORDIN_FORNI_FK
     foreign key (ID_RESTURANT)
     references FORNITORE (ID_FORNITORE);

alter table PIETANZA add constraint REF_PIETA_TIPOL_FK
     foreign key (Tipologia)
     references TIPOLOGIA_PIETANZA (Nome_Tipologia);

alter table PIETANZA add constraint EQU_PIETA_MENU_FK
     foreign key (ID_MENU)
     references MENU (ID_MENU);

alter table PIETANZA_NEL_ORDINE add constraint REF_ID_ORDI
	foreign key (ID_ORDINE)
	references ORDINE (ID_ORDINE);

alter table PIETANZA_NEL_ORDINE add constraint REF_ID_PIET
	foreign key (Nome)
	references PIETANZA (Nome);

-- Added password to Fornitori
ALTER TABLE `fornitore` ADD `Password` VARCHAR(50) NOT NULL AFTER `Email`;
-- Index Section
-- _____________

create unique index ID_CATEGORIA_RISTORANTE_IND
     on CATEGORIA_RISTORANTE (Nome);

create index REF_CATEG_CATEG_IND
     on CATEGORIE (ID_CAT);

create unique index ID_CATEGORIE_IND
     on CATEGORIE (ID_FORNITORE, ID_CAT);

create unique index ID_FORNITORE_IND
     on FORNITORE (ID_FORNITORE);

create unique index SID_MENU_IND
     on MENU (ID_FORNITORE, ID_MENU);

create unique index ID_MESSAGGIO_IND
     on MESSAGGIO (ID_MESS);

create index REF_MESSA_UTENT_IND
     on MESSAGGIO (ID_USER);

create index REF_MESSA_FORNI_IND
     on MESSAGGIO (ID_RESTURANT);

create unique index ID_ORDINE_IND
     on ORDINE (ID_ORDINE);

create index REF_ORDIN_UTENT_IND
     on ORDINE (ID_USER);

create index REF_ORDIN_FORNI_IND
     on ORDINE (ID_RESTURANT);

create unique index ID_PIETANZA_IND
     on PIETANZA (Nome);

create index REF_PIETA_TIPOL_IND
     on PIETANZA (Tipologia);

create index EQU_PIETA_MENU_IND
     on PIETANZA (ID_MENU);

create unique index ID_TIPOLOGIA_PIETANZA_IND
     on TIPOLOGIA_PIETANZA (Nome_Tipologia);

create unique index ID_UTENTE_IND
     on UTENTE (ID_USER);
