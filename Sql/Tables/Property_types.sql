/* Property type table - Stores details of property types fetched from API
 Indexes
 id -> Primary key (Auto increment)
*/
CREATE TABLE `properties`.`property_type` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `title` VARCHAR(50) NOT NULL ,
    `description` TEXT NOT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;