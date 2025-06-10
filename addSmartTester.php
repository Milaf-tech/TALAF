<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Smart Tester</title>
    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          font-family: Arial, sans-serif;
          margin: 0;
          display: flex;
          height: 100vh;
        }

        .container {
          display: flex;
          flex: 1;
          width: 100%;
        }

        .left {
          flex: 1;
          display: flex;
          justify-content: center;
          align-items: center;
          background-color: #f9f9f9;
        }

        .form-container {
          background-color: #fff;
          padding: 30px;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          text-align: center;
          width: 80%;
        }

        h1 {
          color: #333;
          text-align: center;
          margin-bottom: 20px;
          font-size: 2.5em;
        }

        label {
          display: block;
          font-size: 1.1em;
          color: #666;
          margin-bottom: 8px;
          text-align: left;
        }

        input[type="text"],
        input[type="number"] {
          width: 100%;
          padding: 12px;
          margin-bottom: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
          background-color: #f7f7f7;
          font-size: 1em;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
          border-color: #888;
          background-color: #ffffff;
          outline: none;
        }

        button {
          width: 100%;
          padding: 14px;
          background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
          color: white;
          border: none;
          border-radius: 5px;
          font-size: 1.1em;
          font-weight: bold;
          cursor: pointer;
          margin-top: 20px;
          text-transform: uppercase;
        }

        button:hover {
          background-color: #2c0d51;
        }

        .right {
          flex: 1;
          display: flex;
          justify-content: center;
          align-items: center;
          background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
        }

        .right img {
          max-width: 2000%;
          height: auto;
        }

        .popup {
          display: none;
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background-color: #fff;
          padding: 30px;
          border-radius: 8px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          text-align: center;
          width: 300px;
        }

        .popup h2 {
          color: #555;
          font-size: 1.5em;
          margin-bottom: 20px;
        }

        .popup button {
          background: linear-gradient(#b0b0b0,rgb(92, 121, 122));
          padding: 12px 20px;
          color: white;
          border: none;
          border-radius: 5px;
          font-size: 1em;
          cursor: pointer;
          font-weight: bold;
        }

        .popup button:hover {
          background-color: #2c0d51;
        }
    </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="form-container">
        <h1>Add Smart Tester</h1>
        <form id="barcodeForm" method="POST" action="addSmartTester.php">
            <label for="brand-name">Brand name</label>
            <input type="text" id="brand-name" name="brand-name" placeholder="Type name" required>

            <label for="product-name">Product name</label>
            <input type="text" id="product-name" name="product-name" placeholder="Type name" required>
            
            <label for="shade">Shade if any</label>
            <input type="text" id="shade" name="shade" placeholder="Type shade">

            <label for="size">Size</label>
            <input type="text" id="size" name="size" placeholder="Type size" required>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" placeholder="Type price" min="0" required>

            <button type="submit" name="add">Add</button>
        </form>
      </div>
    </div>

    <div class="right">
      <img src="css\logo.png" class="logo" alt="Logo">
    </div>
  </div>

  <div id="successPopup" class="popup">
    <h2>Product added successfully!</h2>
    <button onclick="closePopup()">OK</button>
  </div>

  <?php
    if (isset($_POST['add'])) {
      include 'connection.php';

      $connection = new Connection();

      $brandName = $_POST['brand-name'];
      $productName = $_POST['product-name'];
      $productPrice = $_POST['price'];
      $productShade = $_POST['shade'];
      $productSize = $_POST['size'];

      $query = "INSERT INTO products (productName, productPrice, productShade, productSize, productBrand) 
                VALUES (:productName, :productPrice, :productShade, :productSize, :productBrand)";
      
      $params = [
          ':productName' => $productName,
          ':productPrice' => $productPrice,
          ':productShade' => $productShade,
          ':productSize' => $productSize,
          ':productBrand' => $brandName,
      ];

      $connection->command($query, $params);

      echo "<script>document.getElementById('successPopup').style.display = 'block';</script>";
    }
  ?>

  <script>
    function closePopup() {
      document.getElementById('successPopup').style.display = 'none';
      window.location.href = "showAllSmartTester.php";
    }
  </script>
</body>
</html>
