DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS customerProduct;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS customer;




CREATE TABLE customer (
	customerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	PRIMARY KEY(customerId)
);

CREATE TABLE product (
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productPrice FLOAT(10,2) NOT NULL,
	productDescription VARCHAR (50) NOT NULL,
	PRIMARY KEY(productId)
);

CREATE TABLE customerProduct (
	customerProductId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	customerId INT UNSIGNED NOT NULL,
	FOREIGN KEY(productId) REFERENCES product(productId),
	FOREIGN KEY(customerId) REFERENCES customer(customerId),
	PRIMARY KEY(customerId, productId)

);

CREATE TABLE account (
	accountId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	street1 VARCHAR (128) NOT NULL,
	street2 VARCHAR (128),
	city VARCHAR (128) NOT NULL,
	division VARCHAR (64) NOT NULL,
	country CHAR(2) NOT NULL,
	postalCode INT UNSIGNED NOT NULL,
	PRIMARY KEY(accountId)
);