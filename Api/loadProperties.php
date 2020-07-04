<?php
/**
 * This script will act as a stand alone script to call properties api and get property details.
 * Once the property details are fetched, the data is sanitized and is inserted in property and property type tables.
 * This script can be scheduled in a cron job to execute and update property data at a regular interval.
 */

echo "Script started at ===> " . date("Y-m-d H:i:s") . "\n\n";

define('ROOT', str_replace("Api/loadProperties.php", "", $_SERVER["SCRIPT_FILENAME"]));

// Load required files to execute script
require(ROOT . "Config/config.php");
require(ROOT . "Config/constants.php");
require(ROOT . "Helpers/functions.php");

// PDO connection string
$dbConn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);

// Variable declarations
$properties = [];
$propertyTypes = [];
$responseData = [];
$apiLink = API_REQUEST_URL;

// Call property API and get property data from all the pages till next page url is not null
echo "==========================Calling API and Getting Property Details==============================\n\n";

while (!is_null($apiLink)) {
    $responseData = curlGetRequest($apiLink);
    array_push($properties, $responseData['data']);
    $apiLink = $responseData['next_page_url'];
}

echo "==========================API Executed Successfully==============================\n\n";

// Sanitize property data fetched from API and store it in database
echo "==========================Saving Property Data In Database==============================\n\n";

foreach ($properties as $property) {
    foreach ($property as $propertyData) {
        array_push($propertyTypes, $propertyData['property_type']);
        $propertyData['type'] = ($propertyData['type'] == 'sale') ? TYPE_SALE : TYPE_RENT;
        $propertyData = sanitizeDataArray($propertyData, ['property_type', 'created_at', 'updated_at']);
        saveProperty($propertyData, $dbConn);
    }
}

echo "==========================Property Data Saved In Database==============================\n\n";

// Remove duplicate property types from the array and store property type data in database
$propertyTypes = array_map("unserialize", array_unique(array_map("serialize", $propertyTypes)));

echo "==========================Saving Property Type Data In Database==============================\n\n";

foreach ($propertyTypes as $propertyType) {
    $propertyType = sanitizeDataArray($propertyType, ['created_at', 'updated_at']);
    savePropertyType($propertyType, $dbConn);
}

echo "==========================Property Type Data Saved In Database==============================\n\n";

echo "Script completed at ===> " . date("Y-m-d H:i:s") . "\n\n";

// Function declarations

/**
 * Inserts or Updates property data in database
 *
 * @param array $property Property data
 * @param PDO $conn Database connection string
 *
 */
function saveProperty(array $property, PDO $conn) {
    $sql = "INSERT INTO " . TABLE_PROPERTY . " (uuid, county, country, town, description, display_address, ";
    $sql .= "image_full, image_thumbnail, latitude, longitude, num_bedrooms, num_bathrooms, price, type, ";
    $sql .= "property_type_id) VALUES (:uuid, :county, :country, :town, :description, :display_address, ";
    $sql .= ":image_full, :image_thumbnail, :latitude, :longitude, :num_bedrooms, :num_bathrooms, :price, ";
    $sql .= ":type, :property_type_id) ON DUPLICATE KEY UPDATE county = :county, country = :country, ";
    $sql .= "town = :town, description = :description, display_address = :display_address, image_full = :image_full, ";
    $sql .= "image_thumbnail = :image_thumbnail, latitude = :latitude, longitude = :longitude, ";
    $sql .= "num_bedrooms = :num_bedrooms, num_bathrooms = :num_bathrooms, price = :price, type = :type, ";
    $sql .= "property_type_id = :property_type_id";

    $statement = $conn->prepare($sql);
    $statement->execute([
        'uuid' => $property['uuid'],
        'county' => $property['county'],
        'country' => $property['country'],
        'town' => $property['town'],
        'description' => $property['description'],
        'display_address' => $property['address'],
        'image_full' => $property['image_full'],
        'image_thumbnail' => $property['image_thumbnail'],
        'latitude' => $property['latitude'],
        'longitude' => $property['longitude'],
        'num_bedrooms' => $property['num_bedrooms'],
        'num_bathrooms' => $property['num_bathrooms'],
        'price' => $property['price'],
        'type' => $property['type'],
        'property_type_id' => $property['property_type_id'],
    ]);
}

/**
 * Inserts or Updates property type data in database
 *
 * @param array $propertyType Property type data
 * @param PDO $conn Database connection string
 *
 */
function savePropertyType(array $propertyType, PDO $conn) {
    $sql = "INSERT INTO " . TABLE_PROPERTY_TYPE . "(id, title, description) VALUES (:id, :title, :description) ";
    $sql .= "ON DUPLICATE KEY UPDATE title = :title, description = :description";

    $statement = $conn->prepare($sql);
    $statement->execute([
        'id' => $propertyType['id'],
        'title' => $propertyType['title'],
        'description' => $propertyType['description'],
    ]);
}
