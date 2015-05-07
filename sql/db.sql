DROP TABLE IF EXISTS productOrder;
DROP TABLE IF EXISTS cheqoutOrder;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS address;
DROP TABLE IF EXISTS guest;
DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS email;


CREATE TABLE email (
	emailId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	emailAddress VARCHAR (128) NOT NULL,
	stripeId VARCHAR (25),
	PRIMARY KEY(emailId),
	UNIQUE(emailAddress)
);

CREATE TABLE account (
	accountId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	accountPassword CHAR (128) NOT NULL,
	accountPasswordSalt CHAR (64) NOT NULL,
	activation CHAR (32),
	accountCreateDateTime DATETIME NOT NULL,
	emailId INT UNSIGNED NOT NULL,
	INDEX(emailId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	PRIMARY KEY(accountId),
	UNIQUE(activation)

);

CREATE TABLE guest (
	guestId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	emailId INT UNSIGNED NOT NULL,
	INDEX(emailId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	PRIMARY KEY(guestId)
);

CREATE TABLE address (
	addressId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	emailId VARCHAR (128) NOT NULL,
	addressHidden TINYINT(1) UNSIGNED NOT NULL,
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
	productPrice DECIMAL(20,2) NOT NULL,
	productDescription VARCHAR (500) NOT NULL,
	productInventory INT UNSIGNED,
	productSale INT UNSIGNED,
	PRIMARY KEY(productId)
);

CREATE TABLE cheqoutOrder (
	orderId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	emailId VARCHAR (128) NOT NULL,
	addressId INT UNSIGNED NOT NULL,
	stripeId VARCHAR (25) NOT NULL,
	orderDateTime DATETIME NOT NULL,
	INDEX(emailId),
	INDEX(addressId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	FOREIGN KEY(addressId) REFERENCES address(addressId),
	PRIMARY KEY(orderId)
);

CREATE TABLE productOrder (
	orderId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	quantity INT UNSIGNED NOT NULL,
	shippingCost DECIMAL(10,2) NOT NULL,
	orderPrice DECIMAL(20,2) NOT NULL,
	INDEX(orderId),
	INDEX(orderId),
	FOREIGN KEY(orderId) REFERENCES cheqoutOrder(orderId),
	FOREIGN KEY(productId) REFERENCES product(productId),
	PRIMARY KEY(orderId,productId)
);


