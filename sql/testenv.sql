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
	emailId INT UNSIGNED NOT NULL,
	addressLabel VARCHAR (20),
	addressAttention VARCHAR (100) NOT NULL,
	addressStreet1 VARCHAR (128) NOT NULL,
	addressStreet2 VARCHAR (128),
	addressCity VARCHAR (128) NOT NULL,
	addressState VARCHAR (64) NOT NULL,
	addressZip VARCHAR(10) NOT NULL,
	addressHidden TINYINT(1) UNSIGNED NOT NULL,
	INDEX(emailId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	PRIMARY KEY(addressId)
);

CREATE TABLE product (
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productTitle VARCHAR (128) NOT NULL,
	productPrice DECIMAL(9,2) NOT NULL,
	productDescription VARCHAR (500) NOT NULL,
	productInventory INT UNSIGNED,
	productSale DECIMAL(3,2) NOT NULL,
	PRIMARY KEY(productId)
);

CREATE TABLE cheqoutOrder (
	orderId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	emailId INT UNSIGNED NOT NULL,
	billingAddressId INT UNSIGNED NOT NULL,
	shippingAddressId INT UNSIGNED NOT NULL,
	stripeId VARCHAR (25) NOT NULL,
	orderDateTime DATETIME NOT NULL,
	INDEX(emailId),
	INDEX(billingAddressId),
	INDEX(shippingAddressId),
	FOREIGN KEY(emailId) REFERENCES email(emailId),
	FOREIGN KEY(billingAddressId) REFERENCES address(addressId),
	FOREIGN KEY(shippingAddressId) REFERENCES address(addressId),
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


# So, we want to set up our test environment...BEGIN!

INSERT INTO email(emailId, emailAddress, stripeId) VALUES(1, "oldemail@oldplace.com", "stripeid");

INSERT INTO account(accountPassword, accountPasswordSalt, activation, accountCreateDateTime, emailId)
VALUES("6e09e646a19b5b3006a0ba101d6196b389e987596dd90aa9122c9fa3944eeaf2d92536f1e04626f7047cdc260c2534203ffd3b95b88dfee24c989aee62e10f1d",
		 "ef238ea00a26528de40ff231e5a97f50ef238ea00a26528de40ff231e5a97f50",
		 "ef238ea00a26528de40ff231e5a97f50",
		 "2015-05-22 07:55:51", 1);

INSERT INTO guest(emailId) VALUES(1);

INSERT INTO address(emailId, addressLabel, addressAttention, addressStreet1, addressStreet2, addressCity, addressState, addressZip, addressHidden)
VALUES(1, "work", "mike", "street1", "street2", "city", "state", "45378", 0);

INSERT INTO product(productTitle, productPrice, productDescription, productInventory, productSale )
VALUES("product1", 10.30, "this is the first product", 10, .75);

INSERT INTO product(productTitle, productPrice, productDescription, productInventory, productSale )
VALUES("product2", 11.20, "this is the second product", 11, .85);

INSERT INTO product(productTitle, productPrice, productDescription, productInventory, productSale )
VALUES("product3", 11.10, "this is the third product", 12, .95);

INSERT INTO cheqoutOrder(orderId, emailId, shippingAddressId, billingAddressId, stripeId, orderDateTime)
VALUES (1, 1, 1, 1, "stripeid", "2015-05-22 07:55:51");

INSERT INTO cheqoutOrder(orderId, emailId, shippingAddressId, billingAddressId, stripeId, orderDateTime)
VALUES (2, 1, 1, 1, "stripeid", "2015-05-22 07:56:51");

INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
VALUES(1, 1, 2, 4.00, 8);

INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
VALUES(1, 2, 3, 3.00, 3478);

INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
VALUES(1, 3, 4, 2.00, 324);

INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
VALUES(2, 3, 2, 4.00, 43);

INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
VALUES(2, 2, 3, 3.00, 76);

INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
VALUES(2, 1, 4, 2.00, 12);



# SELECT email.emailAddress,
# 	cheqoutOrder.orderId,
# 	productOrder.quantity,
# 	product.productId,
# 	product.productTitle,
# 	product.productPrice * product.productSale * productOrder.quantity,
# 	address.addressAttention,
# 	address.addressLabel,
# 	address.addressStreet1,
# 	address.addressStreet2,
# 	address.addressCity,
# 	address.addressState,
# 	address.addressZip,
# 	cheqoutOrder.orderDateTime
# FROM email
# INNER JOIN cheqoutOrder ON email.emailId = cheqoutOrder.emailId
# INNER JOIN productOrder ON cheqoutOrder.orderId = productOrder.orderId
# INNER JOIN product ON product.productId = productOrder.productId
# INNER JOIN address ON address.addressId = cheqoutOrder.shippingAddressId
# WHERE cheqoutOrder.orderId = 1;
#
#
# SELECT email.emailAddress,
# 	cheqoutOrder.orderId,
# 	productOrder.quantity,
# 	product.productId,
# 	product.productTitle,
# 	product.productPrice * product.productSale * productOrder.quantity,
# 	shippingCost,
# 	orderPrice,
# 	address.addressAttention,
# 	address.addressLabel,
# 	address.addressStreet1,
# 	address.addressStreet2,
# 	address.addressCity,
# 	address.addressState,
# 	address.addressZip,
# 	cheqoutOrder.orderDateTime
# FROM email
# 	INNER JOIN cheqoutOrder ON email.emailId = cheqoutOrder.emailId
# 	INNER JOIN productOrder ON cheqoutOrder.orderId = productOrder.orderId
# 	INNER JOIN product ON product.productId = productOrder.productId
# 	INNER JOIN address ON address.addressId = cheqoutOrder.shippingAddressId
# WHERE emailAddress = "oldemail@oldplace.com"
# ORDER BY orderDateTime;
#
# INNER JOIN address ON email.emailId = address.emailId;
# INNER JOIN address, cheqoutOrder, product
# WHERE address.addressId = cheqoutOrder.shippingAddressId;
#
#
# SELECT email.emailAddress, cheqoutOrder.orderId
# FROM email
# INNER JOIN cheqoutOrder ON cheqoutOrder.emailId WHERE cheqoutOrder.emailId = email.emailId;
#
# SELECT email.emailId, accountPassword, accountPasswordSalt FROM email
# INNER JOIN account ON email.emailId = account.emailId WHERE emailAddress = "kylacarroll43@gmail.com";


# INSERT INTO cheqoutOrder(orderId, emailId, shippingAddressId, billingAddressId, stripeId, orderDateTime)
# VALUES (3, 2, 1, 1, "stripeid", "2015-05-22 07:55:51");
#
# INSERT INTO cheqoutOrder(orderId, emailId, shippingAddressId, billingAddressId, stripeId, orderDateTime)
# VALUES (4, 2, 1, 1, "stripeid", "2015-05-22 07:56:51");
#
# INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
# VALUES(1, 1, 2, 4.00, 8);
#
# INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
# VALUES(1, 2, 3, 3.00, 3478);
#
# INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
# VALUES(1, 3, 4, 2.00, 324);
#
# INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
# VALUES(2, 3, 2, 4.00, 43);
#
# INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
# VALUES(2, 2, 3, 3.00, 76);
#
# INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
# VALUES(2, 1, 4, 2.00, 12);
