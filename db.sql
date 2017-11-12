DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
    `id` int NOT NULL AUTO_INCREMENT,
    `firstName` varchar(50) DEFAULT NULL,
    `lastName` varchar(50) DEFAULT NULL,
    `email` varchar(254) NOT NULL DEFAULT '',
    `password` varchar(254) NOT NULL DEFAULT '',
    `profileImage` varchar(20) DEFAULT NULL,
    `username` varchar(16) NOT NULL DEFAULT '',
    `active` boolean NOT NULL DEFAULT 0,
    `admin` boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE (`username`),
    UNIQUE (`email`)
);
INSERT INTO `members` (`firstName`, `lastName`, `email`, `password`, `username`, `active`, `admin`) VALUES ('Yousef', 'Alam', 'ay417@greenwich.ac.uk', 'temp', 'yousef', 1, 1);

DROP TABLE IF EXISTS `commutes`;
CREATE TABLE IF NOT EXISTS `commutes` (
    `id` int NOT NULL AUTO_INCREMENT,
    `userId` int NOT NULL,
    `startPoint` varchar(64) NOT NULL,
    `destinationPoint` varchar(64) NOT NULL,
    `arriveBy` time,
    `provides` boolean NOT NULL DEFAULT 0,
    `notes` text DEFAULT NULL,
    `daysAvailable` varchar(64) NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
    `id` int NOT NULL AUTO_INCREMENT,
    `commuteId` int NOT NULL,
    `name` varchar(32),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
    `id` int NOT NULL AUTO_INCREMENT,
    `userId` int NOT NULL,
    `token` int(5),
    `expires` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`token`)
);

ALTER TABLE `commutes`
    ADD FOREIGN KEY (`userId`) REFERENCES `members`(`id`);
ALTER TABLE `images`
    ADD FOREIGN KEY (`commuteId`) REFERENCES `commutes`(`id`);
ALTER TABLE `tokens`
    ADD FOREIGN KEY (`userId`) REFERENCES `members`(`id`);
