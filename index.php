<!DOCTYPE html>
<html>
<head>
  <title>Product Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Product Manager</h2>
    <button class="btn btn-primary my-3" onclick="openModal()">Add Product</button>

    <?php include 'fetch.php'; ?>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" action="backend.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="product-id">
          <div class="mb-2">
            <label>Product Name</label>
            <input type="text" name="productname" id="product-name" class="form-control">
          </div>
          <div class="mb-2">
            <label>Price</label>
            <input type="text" name="price" id="product-price" class="form-control">
          </div>
          <div class="mb-2">
            <label>Quantity</label>
            <input type="number" name="quantity" id="product-quantity" class="form-control">
          </div>
          <div class="mb-2">
            <label>Image File</label>
            <input type="file" name="image" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="action" value="Insert" class="btn btn-success" id="save-btn">Save</button>
          <button type="submit" name="action" value="Update" class="btn btn-warning d-none" id="update-btn">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const modal = new bootstrap.Modal(document.getElementById('productModal'))

    function openModal(product = null) {
      document.getElementById('product-id').value = product ? product.id : '';
      document.getElementById('product-name').value = product ? product.productname : '';
      document.getElementById('product-price').value = product ? product.price : '';
      document.getElementById('product-quantity').value = product ? product.quantity : '';
      document.getElementById('save-btn').classList.toggle('d-none', !!product);
      document.getElementById('update-btn').classList.toggle('d-none', !product);
      modal.show();
    }

    function fillForm(id, name, price, quantity) {
      openModal({ id, productname: name, price, quantity });
    }
  </script>
</body>
</html>
