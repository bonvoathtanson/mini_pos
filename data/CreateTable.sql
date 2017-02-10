CREATE TABLE `Users`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`TokenKey` VARCHAR(255) DEFAULT NULL,
	`Name` VARCHAR(50) NOT NULL,
	`Email` VARCHAR(50),
	`Password` VARCHAR(255) NOT NULL,
	`DateCreated` DATETIME NOT NULL,
	CONSTRAINT PRIMARY KEY (`Id`)
)ENGINE = InnoDB;

CREATE TABLE `Items`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`ItemKey` VARCHAR(255) DEFAULT NULL,
	`ItemCode` VARCHAR(50) NOT NULL,
	`ItemName` NVARCHAR(50) NOT NULL,
	`SalePrice` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`UnitInStock` INT NOT NULL DEFAULT 0,
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`)
)ENGINE = InnoDB;

CREATE TABLE `Customers`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`CustomerKey` VARCHAR(255) DEFAULT NULL,
	`CustomerCode` VARCHAR(50) NOT NULL,
	`CustomerName` NVARCHAR(50) NOT NULL,
	`TypeId` INT DEFAULT 0 NOT NULL,
	`Sex` INT DEFAULT 0 NOT NULL,
	`PhoneNumber` VARCHAR(50),
	`Address` NVARCHAR(255),
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`)
)ENGINE = InnoDB;

CREATE TABLE `CustomerAsks`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`CustomerId` INT NOT NULL,
	`AskDate` DATETIME,
	`Description` TEXT,
	`ConfirmDate` DATETIME NOT NULL,
	`StatusId` INT DEFAULT 0 NOT NULL,
	CONSTRAINT PRIMARY KEY (`Id`),
	CONSTRAINT FOREIGN KEY (`CustomerId`) REFERENCES `Customers`(`Id`)
)ENGINE = InnoDB;

-- IsOrder = 0 => Transfer
-- IsOrder = 1 => Not Transfer
CREATE TABLE `Sales`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`SaleCode` INT NOT NULL,
	`SaleDate` DATETIME NOT NULL,
	`TransferDate` DATETIME NOT NULL,
	`CustomerId` INT NOT NULL,
	`ItemId` INT NOT NULL,
	`CarNumber` VARCHAR(20) NOT NULL,
	`Quantity` INT DEFAULT 0 NOT NULL,
	`SalePrice` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`SubTotal` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`PayAmount` DECIMAL(15,2) DEFAULT 0 NOT NULL,
	`IsOrder` BOOLEAN DEFAULT FALSE NOT NULL,
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`),
	CONSTRAINT FOREIGN KEY (`CustomerId`) REFERENCES `Customers`(`Id`),
	CONSTRAINT FOREIGN KEY (`ItemId`) REFERENCES `Items`(`Id`)
)ENGINE = InnoDB;

CREATE TABLE `Incomes`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`SaleId` INT DEFAULT NULL,
	`IncomeType` INT DEFAULT 0 NOT NULL,
	`IncomeDate` DATETIME NOT NULL,
	`CustomerId` INT DEFAULT NULL,
	`TotalAmount` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`Description` TEXT,
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`),
	CONSTRAINT FOREIGN KEY (`CustomerId`) REFERENCES `Customers`(`Id`),
	CONSTRAINT FOREIGN KEY (`SaleId`) REFERENCES `Sales`(`Id`)
)ENGINE = InnoDB;

CREATE TABLE `Suppliers`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`SupplierKey` VARCHAR(255) DEFAULT NULL,
	`SupplierCode` VARCHAR(50) NOT NULL,
	`SupplierName` NVARCHAR(50) NOT NULL,
	`Sex` INT DEFAULT 0 NOT NULL,
	`PhoneNumber` VARCHAR(50),
	`Address` NVARCHAR(255),
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`)
)ENGINE = InnoDB;

CREATE TABLE `Imports`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`ImportDate` DATETIME NOT NULL,
	`TransferDate` DATETIME NOT NULL,
	`SupplierId` INT NOT NULL,
	`ItemId` INT NOT NULL,
	`CarNumber` VARCHAR(20) NOT NULL,
	`Quantity` INT DEFAULT 0 NOT NULL,
	`SalePrice` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`SubTotal` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`PayAmount` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`IsOrder` INT DEFAULT 0 NOT NULL,
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`),
	CONSTRAINT FOREIGN KEY (`SupplierId`) REFERENCES `Suppliers`(`Id`),
	CONSTRAINT FOREIGN KEY (`ItemId`) REFERENCES `Items`(`Id`)
)ENGINE = InnoDB;

CREATE TABLE `Expanses`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`ImportId` INT DEFAULT NULL,
	`ExpanseType` INT DEFAULT 0 NOT NULL,
	`ExpanseDate` DATETIME NOT NULL,
	`SupplierId` INT DEFAULT NULL,
	`TotalAmount` DECIMAL(18,2) DEFAULT 0 NOT NULL,
	`Description` TEXT,
	`DateCreated` DATETIME NOT NULL,
	`LastUpdated` TIMESTAMP DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PRIMARY KEY (`Id`),
	CONSTRAINT FOREIGN KEY (`SupplierId`) REFERENCES `Suppliers`(`Id`),
	CONSTRAINT FOREIGN KEY (`ImportId`) REFERENCES `Imports`(`Id`)
)ENGINE = InnoDB;

CREATE TABLE `SystemConfigs`(
	`Id` INT NOT NULL,
	`Name` NVARCHAR(255) NOT NULL,
	`Value` VARCHAR(255),
	CONSTRAINT PRIMARY KEY (`Id`)
)ENGINE = InnoDB;

CREATE TABLE `CarNumbers`(
	`Id` INT NOT NULL AUTO_INCREMENT,
	`CarNo` NVARCHAR(255) NOT NULL,
	`Description` TEXT,
	CONSTRAINT PRIMARY KEY (`Id`)
)ENGINE = InnoDB;