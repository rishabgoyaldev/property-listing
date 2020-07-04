$(document).ready(function(){
  loadProperties();
});

/**
* Gets list of all properties and loads it in the properties table
*/
function loadProperties() {
  let table = $('#tblProperties');

  // Get request to get property list
  $.get("/properties/getProperty", function(response) {
    response = JSON.parse(response);

    if (response.status === 200) {
      let records = [];
      let properties = response.data;

      for (let i = 0; i < properties.length; i++) {
        // Create edit and delete button for each property in the list
        let action = '<a href="javascript:editProperty(' + properties[i]['id'] + ')" title="Edit Property">';
        action += '<i class="fa fa-pencil-alt" style="color:#15F541;"></i></a>';
        action += '<a href="javascript:deleteProperty(' + properties[i]['id'] + ')" title="Delete Property">';
        action += '<i class="fa fa-trash" style="color:#DE4949;"></i></a>';

        let type = (properties[i]['type'] == 1) ? 'For Sale' : 'For Rent';

        let thumb = '<img src="' + properties[i]['image_thumbnail'] + '" alt="image" />';

        // Create property rows for table
        records.push({
          series: i + 1,
          action: action,
          image_thumbnail: thumb,
          property_type_title: properties[i]['property_type_title'],
          county: properties[i]['county'],
          country: properties[i]['country'],
          town: properties[i]['town'],
          postcode: properties[i]['postcode'],
          display_address: properties[i]['display_address'],
          num_bedrooms: properties[i]['num_bedrooms'],
          num_bathrooms: properties[i]['num_bathrooms'],
          price: properties[i]['price'],
          type: type
        });
      }

      // Load data in properties table
      table.bootstrapTable('load', records);
    } else {
      $("html, body").animate({ scrollTop: 0 }, "slow");

      // Show alert if some error occurs
      showAlert("pageAlert", "danger", response.message);
    }
  });
}

/**
* Gets details of property to be edited and show details in property form dialog
*/
function editProperty(propertyId) {
  $.get("/properties/getProperty/"+propertyId, function(response) {
    response = JSON.parse(response);

    if (response.status === 200) {
      let property = response.data[0];

      // Sets data in corresponding form field
      $('#property_id').val(property.id);
      $('#county').val(property.county);
      $('#country').val(property.country);
      $('#town').val(property.town);
      $('#postcode').val(property.postcode);
      $('#description').val(property.description);
      $('#display_address').val(property.display_address);
      $('#num_bedrooms').val(property.num_bedrooms);
      $('#num_bathrooms').val(property.num_bathrooms);
      $('#price').val(property.price);
      $('#property_type_id').val(property.property_type_id);
      $(':radio[name=type][value="'+ property.type +'"]').prop('checked', true);
      $('#image_full').hide();

      // Show property modal with property details
      $('#newProperty').modal('show');
    } else {
      // Show error message alert in case of error
      showAlert("modalAlert", "danger", response.message);
    }
  });
}

/**
* Delete property request
*/
function deleteProperty(propertyId) {
  if (confirm("Are you sure you want to delete this property?")) {

    // Delete request to delete property
    $.get("/properties/deleteProperty/"+propertyId, function(response) {
      response = JSON.parse(response);
      $("html, body").animate({ scrollTop: 0 }, "slow");

      if (response.status === 200) {
        // Show success alert message if property is deleted successfully
        showAlert("pageAlert", "success", response.message);

        // Re-load properties table with fresh data
        loadProperties();
      } else {
        // Show error alert message if property is not deleted successfully
        showAlert("pageAlert", "danger", response.message);
      }
    });
  }
}

/**
* Form submit request to add/edit property details
*/
$('#propertyForm').submit(function(e) {
  e.preventDefault();

  // New property url
  let url = "/properties/addProperty";
  let propertyId = $('#property_id').val();

  // Property data from form
  let postData = new FormData(this);

  // Check if edit request and set url for edit property details
  if (propertyId != 0) {
    url = "/properties/editProperty/" + propertyId
  }
  console.log(postData);
  // Post request to add/edit property data
  $.ajax({
    url: url,
    type: 'POST',
    data: postData,
    success: (response) => {
      response = JSON.parse(response);
      $('#newProperty').animate({ scrollTop: 0 }, 'slow');

      if (response.status === 200) {
        if (propertyId == 0) {
          // Clear form fields if add new property request
          clearForm("propertyForm");
        }

        // Show success alert if property is added/updated successfully
        showAlert("modalAlert", "success", response.message);

        // Re-load properties table with fresh data
        loadProperties();
      } else {
        // Show error alert if property is not added/updated successfully
        if (response.data) {
          showAlert("modalAlert", "danger", response.data);
        } else {
          showAlert("modalAlert", "danger", response.message);
        }
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
});

/**
* Clear form on closing property details form dialog
*/
$("#newProperty").on("hidden.bs.modal", function (e) {
  clearForm("propertyForm");
  $('#image_full').show();
});

/**
* Show alert messages with class corresponding to response status
*/
function showAlert(alertId, alertClass, alertMessage) {
  $("#"+alertId).addClass("alert-"+alertClass);
  $("#"+alertId+"Head").html(alertClass.toUpperCase()+"!!!");
  $("#"+alertId+"Message").html(alertMessage);
  $("#"+alertId).show();

  setTimeout(function() {
    $("#"+alertId).hide();
    $("#"+alertId).removeClass("alert-"+alertClass);
    $("#"+alertId+"Head").html("");
    $("#"+alertId+"Message").html("");
  },
    5000
  );
}

/**
* Clear form fields of property form
*/
function clearForm(formId) {
  $("#"+formId).find("input[type!=radio],select,textarea").val('').end();
}
