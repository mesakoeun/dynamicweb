<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<style>
  .table th {
    background-color: #007bff;
    color: white;
    white-space: nowrap;
  }

  td {
    vertical-align: middle;
    word-break: break-word;
    max-width: 150px;
  }

  .wrap-text {
    white-space: normal;
  }

  /* Modal styles */
  .img-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0; width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.7);
    justify-content: center;
    align-items: center;
  }
  .img-modal.active {
    display: flex;
  }
  .img-modal-content {
    position: relative;
    background: transparent;
    padding: 0;
    max-width: 90vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .img-modal-content img {
    max-width: 80vw;
    max-height: 80vh;
    transition: transform 0.2s;
  }
  .img-modal-close {
    position: absolute;
    top: -30px;
    right: 0;
    font-size: 2rem;
    color: white;
    cursor: pointer;
    background: none;
    border: none;
  }
  .img-modal-zoom {
    margin-top: 10px;
    display: flex;
    gap: 10px;
  }
  .img-modal-zoom button {
    font-size: 1.5rem;
    padding: 5px 15px;
    cursor: pointer;
  }
</style>

<!-- Modal HTML -->
<div id="imgModal" class="img-modal">
  <div class="img-modal-content">
    <button class="img-modal-close" onclick="closeImgModal()">&times;</button>
    <img id="modalImg" src="" alt="Preview">
    <div class="img-modal-zoom">
      <button onclick="zoomImg(-0.2)">-</button>
      <button onclick="zoomImg(0.2)">+</button>
    </div>
  </div>
</div>

<table class="table table-bordered table-hover text-center align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Product Name</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Image</th>
      <th class="wrap-text">Created At</th>
      <th class="wrap-text">Updated At</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    require_once 'config/dbconfig.php';

    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
      $stmt = $pdo->query("SELECT * FROM product_items");

      while ($row = $stmt->fetch()) {
        $imgSrc = htmlspecialchars($row['image'], ENT_QUOTES);
        echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['productname']}</td>
          <td>\${$row['price']}</td>
          <td>{$row['quantity']}</td>
          <td>
            <img src='{$imgSrc}' width='50' style='cursor:pointer' onclick=\"openImgModal('{$imgSrc}')\">
          </td>
          <td class='wrap-text'>{$row['create_at']}</td>
          <td class='wrap-text'>{$row['update_at']}</td>
          <td>
            <button class='btn btn-sm btn-warning' onclick=\"fillForm(
              '{$row['id']}', '{$row['productname']}', '{$row['price']}', '{$row['quantity']}'
            )\">Update</button>
            <form action='backend.php' method='post' style='display:inline'>
              <input type='hidden' name='id' value='{$row['id']}'>
              <button type='submit' name='action' value='Delete' class='btn btn-sm btn-danger'>Delete</button>
            </form>
          </td>
        </tr>";
      }
    ?>
  </tbody>
</table>

<script>
  let currentZoom = 1;
  function openImgModal(src) {
    document.getElementById('modalImg').src = src;
    document.getElementById('imgModal').classList.add('active');
    currentZoom = 1;
    document.getElementById('modalImg').style.transform = 'scale(1)';
  }
  function closeImgModal() {
    document.getElementById('imgModal').classList.remove('active');
    document.getElementById('modalImg').src = '';
  }
  function zoomImg(delta) {
    currentZoom += delta;
    if (currentZoom < 0.2) currentZoom = 0.2;
    if (currentZoom > 5) currentZoom = 5;
    document.getElementById('modalImg').style.transform = 'scale(' + currentZoom + ')';
  }
  // Optional: Close modal on background click
  document.getElementById('imgModal').addEventListener('click', function(e) {
    if (e.target === this) closeImgModal();
  });
</script>