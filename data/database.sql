CREATE TABLE cliente(
CustomerID INTEGER,
CustomerTaxID INTEGER,
CompanyName VARCHAR,
AddressDetail VARCHAR,
Cidade VARCHAR,
PostalCode INTEGER,
Country INTEGER,
Email VARCHAR
);

CREATE TABLE produto(
ProductCode INTEGER,
ProductDescription VARCHAR,
unitPrice REAL,
unitofMeasure VARCHAR
);

CREATE TABLE fatura(
InvoiceNo VARCHAR,
InvoiceDate VARCHAR,
CustomerID INTEGER,
LineID INTEGER REFERENCES line(LineID), 
TaxPayable REAL,
NetTotal REAL,
GrossTotal REAL
);

CREATE TABLE line(
LineID INTEGER, /*PRIMARY KEY*/
LineNumber INTEGER, /*INCREMENTAL*/
ProductCode INTEGER REFERENCES produto(ProductCode),
Quantity  INTEGER,
CreditAmount  INTEGER,
TaxID VARCHAR REFERENCES tax(TaxID)
);

CREATE TABLE tax(
TaxID INTEGER,
TaxType VARCHAR,
TaxPercentage REAL
);

CREATE TABLE users(
  Username VARCHAR,
  Password VARCHAR,
  Permission INTEGER
);

/* LINES */
INSERT INTO line VALUES('4','1','1','10','3000','1337');
INSERT INTO line VALUES('4','2','2','10','3000','1337');
INSERT INTO line VALUES('4','3','3','10','3000','1337');
INSERT INTO line VALUES('4','4','4','10','3000','1337');
INSERT INTO line VALUES('4','5','5','10','3000','1337');
INSERT INTO line VALUES('4','6','6','10','3000','1337');
INSERT INTO line VALUES('4','7','7','10','3000','1337');
INSERT INTO line VALUES('4','8','8','10','3000','1337');
INSERT INTO line VALUES('4','9','9','10','3000','1337');
INSERT INTO line VALUES('5','1','1','10','3000','1337');
INSERT INTO line VALUES('5','2','2','10','3000','1337');
INSERT INTO line VALUES('5','3','3','10','3000','1337');
INSERT INTO line VALUES('5','4','4','10','3000','1337');
INSERT INTO line VALUES('5','5','5','10','3000','1337');



/* FATURAS */
INSERT INTO fatura VALUES('FT SEQ/1','2010-09-27','1','5','690','3000','3695');
INSERT INTO fatura VALUES('FT SEQ/2','2011-09-27','2','4','690','3000','3692');
INSERT INTO fatura VALUES('FT SEQ/3','2012-09-27','3','5','690','3000','3693');
INSERT INTO fatura VALUES('FT SEQ/4','2013-01-27','4','4','690','3000','3690');
INSERT INTO fatura VALUES('FT SEQ/5','2013-02-27','5','5','690','3000','3699');
INSERT INTO fatura VALUES('FT SEQ/6','2013-03-27','6','4','690','3000','3693');
INSERT INTO fatura VALUES('FT SEQ/7','2013-04-27','7','5','690','3000','3697');
INSERT INTO fatura VALUES('FT SEQ/8','2013-05-27','8','5','690','3000','3698');
INSERT INTO fatura VALUES('FT SEQ/9','2013-06-27','9','5','690','3000','36905');


/* TAXES */
INSERT INTO tax VALUES('1337','IVA','24');
INSERT INTO tax VALUES('1337','WHAT','4');

/* USERS */
INSERT INTO users VALUES('admin','admin','1');
INSERT INTO users VALUES('editor','editor','2');
INSERT INTO users VALUES('leitor','leitor','3');
INSERT INTO users VALUES('user1','user1','3');
INSERT INTO users VALUES('user2','user2','3');
INSERT INTO users VALUES('user3','user3','3');

/* CLIENTE */
INSERT INTO cliente VALUES('1','71','companyname1','address1','porto','4200','351','cl1@gmail.com');
INSERT INTO cliente VALUES('2','72','companyname2','address2','porto','4200','351','cl2@gmail.com');
INSERT INTO cliente VALUES('3','73','companyname3','address3','porto','4200','351','cl3@gmail.com');
INSERT INTO cliente VALUES('4','74','companyname4','address4','porto','4200','351','cl4@gmail.com');
INSERT INTO cliente VALUES('5','75','companyname5','address5','porto','4200','351','cl5@gmail.com');
INSERT INTO cliente VALUES('6','76','companyname6','address6','porto','4200','351','cl6@gmail.com');
INSERT INTO cliente VALUES('7','77','companyname7','address7','porto','4200','351','cl7@gmail.com');
INSERT INTO cliente VALUES('8','78','companyname8','address8','porto','4200','351','cl8@gmail.com');
INSERT INTO cliente VALUES('9','79','companyname9','address9','porto','4200','351','cl9@gmail.com');

/* PRODUTOS */
INSERT INTO produto VALUES('1','produto1','31.5','meter');
INSERT INTO produto VALUES('2','produto2','32.5','meter');
INSERT INTO produto VALUES('3','produto3','33.5','meter');
INSERT INTO produto VALUES('4','produto4','34.5','meter');
INSERT INTO produto VALUES('5','produto5','35.5','meter');
INSERT INTO produto VALUES('6','produto6','36.5','meter');
INSERT INTO produto VALUES('7','produto7','37.5','meter');
INSERT INTO produto VALUES('8','produto8','38.5','meter');
INSERT INTO produto VALUES('9','produto9','39.5','meter');
INSERT INTO produto VALUES('10','produto10','310.5','meter');
INSERT INTO produto VALUES('11','produto11','311.5','meter');
INSERT INTO produto VALUES('12','produto12','312.5','meter');
INSERT INTO produto VALUES('13','produto13','313.5','meter');
INSERT INTO produto VALUES('14','produto14','314.5','meter');
INSERT INTO produto VALUES('15','produto15','315.5','meter');
INSERT INTO produto VALUES('16','produto16','316.5','meter');
INSERT INTO produto VALUES('17','produto17','317.5','meter');
INSERT INTO produto VALUES('18','produto18','320.5','meter');
INSERT INTO produto VALUES('19','produto19','320.5','meter');
INSERT INTO produto VALUES('20','produto20','302.5','meter');





  