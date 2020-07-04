<div id="newProperty" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Property Details</h4>
      </div>
      <div class="modal-body">
        <div class="alert" id="modalAlert" style="display: none;">
          <strong id="modalAlertHead"></strong> <span id="modalAlertMessage"></span>
        </div>
        <form id="propertyForm" method="post" enctype="multipart/form-data">
          <input type="hidden" id="property_id" name="property_id" value="0" />
          <div class="form-group">
            <label for="county">County</label>
            <input type="text" class="form-control" name="county" id="county" placeholder="Oregon" required />
          </div>
          <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" name="country" id="country" placeholder="Ethiopia" required />
          </div>
          <div class="form-group">
            <label for="town">Town</label>
            <input type="text" class="form-control" name="town" id="town" placeholder="Colemouth" required />
          </div>
          <div class="form-group">
            <label for="postcode">Postcode</label>
            <input type="text" class="form-control" name="postcode" id="postcode" placeholder="AB123" required />
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" placeholder="Property Description" required></textarea>
          </div>
          <div class="form-group">
            <label for="display_address">Display Address</label>
            <input type="text" class="form-control" name="display_address" id="display_address" placeholder="920 Nellie Ranch" required />
          </div>
          <div class="form-group">
            <label for="image_full">Image</label>
            <input type="file" class="form-control" name="image_full" id="image_full" />
          </div>
          <div class="form-group">
            <label for="num_bedrooms">Bedrooms</label>
            <select class="form-control" name="num_bedrooms" id="num_bedrooms" required>
              <option value="">--Select--</option>
              <?php for($i = 1; $i <= 20; $i++): ?>
                <option value="<?= $i; ?>"><?= $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="num_bathrooms">Bathrooms</label>
            <select class="form-control" name="num_bathrooms" id="num_bathrooms" required>
              <option value="">--Select--</option>
              <?php for($i = 1; $i <= 20; $i++): ?>
                <option value="<?= $i; ?>"><?= $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="1000.21" required />
          </div>
          <div class="form-group">
            <label for="property_type_id">Property Type</label>
            <select class="form-control" name="property_type_id" id="property_type_id" required>
              <option value="">-- Select Property Type --</option>
              <?php foreach ($propertyTypes as $propertyType): ?>
                <option value=<?= $propertyType['id']; ?>><?= $propertyType['title']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Type</label>
            <input type="radio" name="type" value="1" checked>For Sale
            <input type="radio" name="type" value="2">For Rent
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
