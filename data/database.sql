CREATE TABLE cliente(
CustomerID INTEGER PRIMARY KEY AUTOINCREMENT,
CustomerTaxID INTEGER,
CompanyName VARCHAR,
AddressDetail VARCHAR,
Cidade VARCHAR,
PostalCode INTEGER,
Country INTEGER,
Email VARCHAR
);


/* CLIENTE */
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('71','companyname1','address1','porto','4200','351','cl1@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('72','companyname2','address2','porto','4200','351','cl2@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('73','companyname3','address3','porto','4200','351','cl3@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('74','companyname4','address4','porto','4200','351','cl4@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('75','companyname5','address5','porto','4200','351','cl5@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('76','companyname6','address6','porto','4200','351','cl6@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('77','companyname7','address7','porto','4200','351','cl7@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('78','companyname8','address8','porto','4200','351','cl8@gmail.com');
INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES('79','companyname9','address9','porto','4200','351','cl9@gmail.com');





CREATE TABLE fatura(
Num INTEGER PRIMARY KEY AUTOINCREMENT,
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
LineNumber INTEGER PRIMARY KEY AUTOINCREMENT,
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
  Username VARCHAR UNIQUE,
  Password VARCHAR,
  Permission INTEGER
);

/* LINES */
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('1','1','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('1','2','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('2','3','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('2','4','10','3000','2');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('3','5','10','3000','2');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('3','6','10','3000','2');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('4','7','10','3000','2');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('4','8','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('5','9','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('5','1','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('6','2','10','3000','2');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('6','2','10','3000','2');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('7','3','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('7','4','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('8','5','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('8','5','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('9','5','10','3000','1');
INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('9','5','10','3000','1');



/* FATURAS */
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/1','2010-09-27','1','1','690','3000','3695');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/2','2011-09-27','2','2','690','3000','3692');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/3','2012-09-27','3','3','690','3000','3693');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/4','2013-01-27','4','4','690','3000','3690');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/5','2013-02-27','5','5','690','3000','3699');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/6','2013-03-27','6','6','690','3000','3693');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/7','2013-04-27','7','7','690','3000','3697');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/8','2013-05-27','8','8','690','3000','3698');
INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/9','2013-06-27','9','9','690','3000','36905');


/* TAXES */
INSERT INTO tax VALUES('1','IVA','23');
INSERT INTO tax VALUES('2','IS','4');

/* USERS */
INSERT INTO users VALUES('admin','admin','1');
INSERT INTO users VALUES('editor','editor','2');
INSERT INTO users VALUES('leitor','leitor','3');
INSERT INTO users VALUES('user1','user1','3');
INSERT INTO users VALUES('user2','user2','3');
INSERT INTO users VALUES('user3','user3','3');



/* PRODUTOS */

CREATE TABLE produto(
ProductCode INTEGER PRIMARY KEY AUTOINCREMENT,
ProductDescription VARCHAR,
unitPrice REAL,
unitofMeasure VARCHAR
);

INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto1','31.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto2','32.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto3','33.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto4','21.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto5','11.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto6','32.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto7','35.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto8','36.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto10','341.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto11','311.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto11','321.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto12','331.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto13','391.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto14','381.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto15','3001.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto16','301.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto17','391.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto18','381.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto19','366.5','meter');
INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES ('produto20','3666.5','meter');
