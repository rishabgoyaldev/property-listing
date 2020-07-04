<?php require 'propertyForm.php' ?>
<h1>Property List</h1>
<hr>
<div class="alert" id="pageAlert" style="display: none;">
  <strong id="pageAlertHead"></strong> <span id="pageAlertMessage"></span>
</div>
<div class="table-responsive">
  <div class="fixed-table-toolbar">
    <div class="pull-left search input-group">
      <div class="btn-group">
        <button class="btn btn-primary btn-small" data-toggle="modal" data-target="#newProperty">
          <span class="fa fa-plus"></span>
          Add New Property
        </button>
      </div>
    </div>
  </div>
  <table class="table table-hover table-bordered data-table"
    id = "tblProperties"
    data-pagination = "true"
    data-toggle = "table"
    data-search = "true"
  >
    <thead>
      <tr>
        <th data-field="series" data-sortable="true">Num</th>
        <th data-field="action">Action</th>
        <th data-field="image_thumbnail">Image</th>
        <th data-field="property_type_title" data-sortable="true">Property Type</th>
        <th data-field="county" data-sortable="true">County</th>
        <th data-field="country" data-sortable="true">Country</th>
        <th data-field="town" data-sortable="true">Town</th>
        <th data-field="postcode" data-sortable="true">Postcode</th>
        <th data-field="display_address">Address</th>
        <th data-field="num_bedrooms" data-sortable="true">Bedrooms</th>
        <th data-field="num_bathrooms" data-sortable="true">Bathrooms</th>
        <th data-field="price" data-sortable="true">Price</th>
        <th data-field="type" data-sortable="true">Type</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<script src="/Public/assets/js/tables.min.js"></script>
<script src="/Public/assets/js/main.js"></script>
