<?php
// Response codes
define('SUCCESS_REQUEST', 200);
define('INVALID_REQUEST', 400);
define('REQUEST_NOT_FOUND', 404);
define('INTERNAL_SERVER_ERROR', 500);

// Server Error Response
define('SERVER_ERROR_RESPONSE', [
    'status' => INTERNAL_SERVER_ERROR,
    'message' => 'Internal server error!! Please try again in sometime.'
]);

// Database tables
define('TABLE_PROPERTY', 'property');
define('TABLE_PROPERTY_TYPE', 'property_type');

// Property ownership types
define('TYPE_SALE', 1);
define('TYPE_RENT', 2);

// Images and thumbnails
define('FULL_IMAGE_PATH', ROOT . '/Data/Uploads/Images/Full/');
define('THUMBNAIL_PATH', ROOT . '/Data/Uploads/Images/Thumbnails/');
define('FULL_IMAGE_PATH_DB', '/Data/Uploads/Images/Full/');
define('THUMBNAIL_PATH_DB', '/Data/Uploads/Images/Thumbnails/');
define('THUMBNAIL_WIDTH', 100);
define('THUMBNAIL_HEIGHT', 100);