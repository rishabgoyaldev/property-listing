/* Property table - Stores property details
 Indexes
 id -> Primary key (Auto increment)
 uuid -> Unique (Identifier to differentiate propertied fetched from API and inserted manually
*/
CREATE TABLE `properties`.`property` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `uuid` VARCHAR(50) NULL DEFAULT NULL ,
    `county` VARCHAR(50) NOT NULL ,
    `country` VARCHAR(100) NOT NULL ,
    `town` VARCHAR(50) NOT NULL ,
    `description` TEXT NOT NULL ,
    `display_address` VARCHAR(256) NOT NULL ,
    `image_full` VARCHAR(256) NOT NULL ,
    `image_thumbnail` VARCHAR(256) NOT NULL ,
    `latitude` VARCHAR(50) NULL DEFAULT NULL ,
    `longitude` VARCHAR(50) NULL DEFAULT NULL ,
    `num_bedrooms` TINYINT UNSIGNED NOT NULL ,
    `num_bathrooms` TINYINT UNSIGNED NOT NULL ,
    `price` DECIMAL(10,2) NOT NULL ,
    `type` ENUM('1','2') NOT NULL COMMENT '1 = sale, 2 = rent' ,
    `property_type_id` TINYINT UNSIGNED NOT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE `uuid` (`uuid`)
) ENGINE = InnoDB;