<?php
class Properties extends Controller {
    /**
    * @property object $propertyModel Property model class object
    */
    private $propertyModel;

    /**
    * Constructor
    *
    */
    function __construct() {
        $this->propertyModel = $this->loadModel('Property');
        $this->loadHelper('functions');
    }

    /**
    * Gets list of all properties
    *
    */
    function index() {
        $propertyTypeModel = $this->loadModel('Propertytype');

        $data['propertyTypes'] = $propertyTypeModel->getAll();

        $this->setData($data);
        $this->renderView("index");
    }

    /**
    * Gets details of the property for the given property id
    *
    * @param int $propertyId Property id
    *
    */
    function getProperty(int $propertyId = 0) {
        $response = SERVER_ERROR_RESPONSE;
        $propertyId = sanitizeData($propertyId);

        $propertyDetails = $this->propertyModel->get($propertyId);

        if ($propertyDetails) {
            $response = [
                "status" => SUCCESS_REQUEST,
                "message" => "Property found.",
                "data" => $propertyDetails
            ];
        }

        echo json_encode($response);
    }

    /**
    * Add new property details
    */
    function addProperty() {
        $response = SERVER_ERROR_RESPONSE;
        $postVars = $_POST;
        $fileVars = $_FILES;

        $requestErrors = $this->checkPostFields($postVars);

        if (empty($fileVars['image_full']['tmp_name'])) {
            $requestErrors[] = "Image is required";
        }

        if (empty($requestErrors)) {
          $postVars = sanitizeDataArray($postVars);
          $uploadedImage = $this->uploadImage($fileVars['image_full']);
          $postVars['image_full'] = FULL_IMAGE_PATH_DB . $uploadedImage['name'];

          if ($postVars['image_full'] == 'Error') {
              $response = [
                "status" => INVALID_REQUEST,
                "message" => "Please select only an image file (.jpg, .png, .gif)."
              ];
          } else {
              $uploadedThumb = $this->generateThumbnail($uploadedImage['path']);
              $postVars['image_thumbnail'] = THUMBNAIL_PATH_DB . $uploadedThumb;

              $newProperty = $this->propertyModel->add($postVars);

              if ($newProperty) {
                  $response = [
                    "status" => SUCCESS_REQUEST,
                    "message" => "Property added successfully."
                  ];
              }
          }
        } else {
          $response = [
            "status" => INVALID_REQUEST,
            "message" => "Invalid request. Mandatory data missing in request.",
            "data" => implode("<br>", $requestErrors)
          ];
        }

        echo json_encode($response);
    }

    /**
    * Edit property details
    *
    * @param int $propertyId Property id
    *
    */
    function editProperty($propertyId = 0) {
        $response = SERVER_ERROR_RESPONSE;
        $postVars = $_POST;

        if ($propertyId == 0) {
          $response = [
            "status" => INVALID_REQUEST,
            "message" => "Property id is required."
          ];
        } else {
          $requestErrors = $this->checkPostFields($postVars);

          if (empty($requestErrors)) {
            $postVars = sanitizeDataArray($postVars);
            $propertyId = sanitizeData($propertyId);

            $editProperty = $this->propertyModel->update($propertyId, $postVars);

            if ($editProperty) {
              $response = [
                "status" => SUCCESS_REQUEST,
                "message" => "Property updated successfully."
              ];
            }
          } else {
            $response = [
              "status" => INVALID_REQUEST,
              "message" => "Invalid request. Mandatory data missing in request.",
              "data" => implode("<br>", $requestErrors)
            ];
          }
        }

        echo json_encode($response);
    }

    /**
    * Delete property details
    *
    * @param int $propertyId Property id
    *
    */
    function deleteProperty($propertyId = 0) {
        $response = SERVER_ERROR_RESPONSE;

        if ($propertyId == 0) {
          $response = [
            "status" => INVALID_REQUEST,
            "message" => "Property id is required."
          ];
        } else {
          $propertyId = sanitizeData($propertyId);

          $deleteProperty = $this->propertyModel->delete($propertyId);

          if ($deleteProperty) {
            $response = [
              "status" => SUCCESS_REQUEST,
              "message" => "Property deleted successfully."
            ];
          }
        }

        echo json_encode($response);
    }

    /**
    * Checks if uploaded file is an image and moves it to image uploads directory
    *
    * @param array $image Image file
    *
    * @return array
    */
    private function uploadImage(array $image): array {
        if (preg_match('/[.](jpg)|(gif)|(png)$/', $image['name'])) {
            $imageName = getRandomString() . "_" . $image['name'];
            $path = FULL_IMAGE_PATH . $imageName;
            move_uploaded_file($image['tmp_name'], $path);

            return ["path" => $path, "name" => $imageName];
        }

        return 'Error';
    }

    /**
    * Generate thumbnail version of the uploaded property image
    *
    * @param string $image Uploaded image path
    *
    * @return string
    */
    private function generateThumbnail(string $image): string {
        $imageDetails = pathinfo($image);

        if (preg_match('/[.]jpg$/', $image)) {
            $imgCreated = imagecreatefromjpeg($image);
        } elseif (preg_match('/[.]gif$/', $image)) {
            $imgCreated = imagecreatefromgif($image);
        } elseif (preg_match('/[.]png$/', $image)) {
            $imgCreated = imagecreatefrompng($image);
        }

        $width = imagesx($imgCreated);
        $height = imagesy($imgCreated);
        $thumb = imagecreatetruecolor(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
        imagecopyresized(
            $thumb,
            $imgCreated,
            0,
            0,
            0,
            0,
            THUMBNAIL_WIDTH,
            THUMBNAIL_HEIGHT,
            $width,
            $height
        );
        $path = THUMBNAIL_PATH . $imageDetails['basename'];
        imagejpeg($thumb, $path);

        return $imageDetails['basename'];
    }

    /**
    * Checks if all required data is submitted in add/edit property request
    *
    * @param array $data Post data
    *
    * @return array
    */
    private function checkPostFields(array $data): array {
        $errors = [];

        if (empty($data['county'])) {
            $errors[] = 'County is required.';
        }

        if (empty($data['country'])) {
            $errors[] = 'Country is required.';
        }

        if (empty($data['town'])) {
            $errors[] = 'Town is required.';
        }

        if (empty($data['postcode'])) {
            $errors[] = 'Postcode is required.';
        }

        if (empty($data['description'])) {
            $errors[] = 'Description is required.';
        }

        if (empty($data['display_address'])) {
            $errors[] = 'Display address is required.';
        }

        if (empty($data['num_bedrooms'])) {
            $errors[] = 'Number of bedrooms is required.';
        }

        if (empty($data['num_bathrooms'])) {
            $errors[] = 'Number of bathrooms is required.';
        }

        if (empty($data['price'])) {
            $errors[] = 'Price is required.';
        }

        if (empty($data['property_type_id'])) {
            $errors[] = 'Property type is required.';
        }

        return $errors;
    }
}
