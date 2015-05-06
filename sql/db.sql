DROP TABLE IF EXISTS productOrder;
DROP TABLE IF EXISTS cheqoutOrder;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS address;
DROP TABLE IF EXISTS guest;
DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS email;


CREATE TABLE email (
	emailId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	emailAddress UNIQUE VARCHAR (128) NOT NULL,
	stripeId VARCHAR (25) NOT NULL,
	PRIMARY KEY (emailId)
);

CREATE TABLE account (
	accountId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	accountPassword CHAR (128) NOT NULL,
	accountPasswordSalt CHAR (64) NOT NULL,
	activation UNIQUE CHAR (32) NULLABLE,
	accountCreateDateTime DATETIME NOT NULL,
	emailId INT UNSIGNED NOT NULL,
	INDEX(emailId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	PRIMARY KEY(accountId)
);

CREATE TABLE guest (
	guestId INT AUTO_INCREMENT NOT NULL,
	emailId INT NOT NULL,
	INDEX(emailId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	PRIMARY KEY(guestId)
);

CREATE TABLE address (
	addressId INT AUTO_INCREMENT NOT NULL,
	emailId VARCHAR (128) NOT NULL,
	addressHidden CHAR(1) NOT NULL,
	addressAttention VARCHAR (100) NOT NULL,
	addressStreet1 VARCHAR (128) NOT NULL,
	addressStreet2 VARCHAR (128),
	addressCity VARCHAR (128) NOT NULL,
	addressState VARCHAR (64) NOT NULL,
	addressCountry CHAR(2) NOT NULL,
	addressZip VARCHAR(10) NOT NULL,
	addressLabel VARCHAR (20),
	INDEX(emailId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	PRIMARY KEY(addressId)
);

CREATE TABLE product (
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productTitle VARCHAR (128) NOT NULL,
	productPrice FLOAT(20,2) NOT NULL,
	productDescription VARCHAR (500) NOT NULL,
	productInventory INT NULLABLE,
	productSale INT NULLABLE,
	PRIMARY KEY(productId)
);

CREATE TABLE cheqoutOrder (
	orderId INT AUTO_INCREMENT NOT NULL,
	emailId VARCHAR (128) NOT NULL,
	addressId INT NOT NULL,
	stripeId VARCHAR (25) NOT NULL,
	orderDateTime DATETIME NOT NULL,
	INDEX(emailId),
	INDEX(addressId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	FOREIGN KEY(addressId) REFERENCES address(addressId),
	PRIMARY KEY(orderId)
);

CREATE TABLE productOrder (
	orderId INT NOT NULL,
	productId INT NOT NULL,
	quantity INT NOT NULL,
	shippingCost FLOAT (10,2) NOT NULL,
	orderPrice FLOAT (20,2) NOT NULL,
	INDEX(orderId),
	INDEX(orderId),
	FOREIGN KEY(orderId) REFERENCES cheqoutOrder(orderId),
	FOREIGN KEY(productId) REFERENCES product(productId)
);


