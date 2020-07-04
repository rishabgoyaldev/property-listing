<?php
class Property extends Model {
  /**
  * Constructor
  */
  function __construct() {
    parent::__construct();
  }

  /**
  * Get list of all or selected property
  *
  * @param int $propertyId Property id
  *
  * @return array
  */
  function get(int $propertyId = 0): array {
    $sql = "SELECT a.*, b.title as property_type_title FROM " . TABLE_PROPERTY . " a INNER JOIN " . TABLE_PROPERTY_TYPE . " b ON ";
    $sql .= "a.property_type_id = b.id";

    if ($propertyId != 0) {
      $sql .= " WHERE a.id = '$propertyId'";
    }

    $statement = $this->db->conn->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
  }

  /**
  * Insert new property details
  *
  * @param array $propertyData Property data
  *
  * @return bool
  */
  function add(array $propertyData): bool {
    $sql = "INSERT INTO " . TABLE_PROPERTY . " (county, country, town, postcode, description, display_address, ";
    $sql .= "image_full, image_thumbnail, num_bedrooms, num_bathrooms, price, type, ";
    $sql .= "property_type_id) VALUES (:county, :country, :town, :postcode, :description, :display_address, ";
    $sql .= ":image_full, :image_thumbnail, :num_bedrooms, :num_bathrooms, :price, ";
    $sql .= ":type, :property_type_id)";

    $statement = $this->db->conn->prepare($sql);

    if ($statement->execute([
        'county' => $propertyData['county'],
        'country' => $propertyData['country'],
        'town' => $propertyData['town'],
        'postcode' => $propertyData['postcode'],
        'description' => $propertyData['description'],
        'display_address' => $propertyData['display_address'],
        'image_full' => $propertyData['image_full'],
        'image_thumbnail' => $propertyData['image_thumbnail'],
        'num_bedrooms' => $propertyData['num_bedrooms'],
        'num_bathrooms' => $propertyData['num_bathrooms'],
        'price' => $propertyData['price'],
        'type' => $propertyData['type'],
        'property_type_id' => $propertyData['property_type_id'],
    ])) {
      return true;
    } else {
      return false;
    }
  }

  /**
  * Update details of the given property id
  *
  * @param int $propertyId Property id
  * @param array $propertyData Property data
  *
  * @return bool
  */
  function update(int $propertyId, array $propertyData): bool {
    $sql = "UPDATE " . TABLE_PROPERTY . " SET county = :county, country = :country, town = :town, description = :description, ";
    $sql .= "postcode = :postcode, display_address = :display_address, ";
    $sql .= "num_bedrooms = :num_bedrooms, num_bathrooms = :num_bathrooms, ";
    $sql .= "price = :price, type = :type, property_type_id = :property_type_id WHERE id = :id";

    $statement = $this->db->conn->prepare($sql);

    if ($statement->execute([
      'id' => $propertyId,
      'county' => $propertyData['county'],
      'country' => $propertyData['country'],
      'town' => $propertyData['town'],
      'postcode' => $propertyData['postcode'],
      'description' => $propertyData['description'],
      'display_address' => $propertyData['display_address'],
      'num_bedrooms' => $propertyData['num_bedrooms'],
      'num_bathrooms' => $propertyData['num_bathrooms'],
      'price' => $propertyData['price'],
      'type' => $propertyData['type'],
      'property_type_id' => $propertyData['property_type_id'],
    ])) {
      return true;
    }

    return false;
  }

  /**
  * Delete details of the given property id
  *
  * @param int $propertyId Property id
  *
  * @return bool
  */
  function delete(int $propertyId): bool {
    $sql = "DELETE FROM " . TABLE_PROPERTY . " WHERE id = :id";
    $statement = $this->db->conn->prepare($sql);

    if ($statement->execute([
      'id' => $propertyId
    ])) {
      return true;
    }

    return false;
  }
}
