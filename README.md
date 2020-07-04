# Property listing app

This is a PHP web application to display and perform CRUD actions on properties listed in the app.  

# Architecture

I have implemented a custom MVC framework for PHP applications.

Only Public and Data directories are accessible and access to other directories are restricted.

SQL directory contains a list of all database tables and their description.

The entry point to the application is Public/index.php.

As soon as the system receives the request, the dispatcher, request and router checks if a request is made to a valide controller and method.

If not, page not found controller is loaded.

## Database

I have created two database tables for the system requirements

1) Property - Stores details of all the properties in the system.
2) Property types - Stores details of different property types
 
### Property API

To get list of properties and property types from the property API, I have created a stand alone script that can be run from CLI.

The script is located at `Api/loadProperties.php`

The script makes a secure PDO connection to database and then calls the property api to fetch the list of properties. The API is called till the `next_page_url` parameter in the API response is null.

All the property records are stored in an array and then we loop through all the properties to sanitize data and insert in database.

We also get all unique property type from the property array and insert them in property types table.
   
## Admin area

The methods for CRUD actions on properties are written and executed using Property controller and model.

To eliminate security threats and follow best practices, queries are written using prepared statements.

While adding a property, images and thumbs are uploaded in Data directory and the path is stored in database.

To display properties, I have use data tables for a better user experience and real time alerting and data manipulation.  

## Future developments

I could not implement an image preview and edit property image functionality for the system due to time limit.

The next set of activities will be to incorporate these functionalities.