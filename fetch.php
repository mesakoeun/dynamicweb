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
</style>

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
        echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['productname']}</td>
          <td>\${$row['price']}</td>
          <td>{$row['quantity']}</td>
          <td><img src='{$row['image']}' width='50'></td>
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
