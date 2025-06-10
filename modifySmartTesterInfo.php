<?php
require_once("connection.php");

$connection = new Connection();

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $query = "SELECT * FROM products WHERE productID = :id";
    $params = [':id' => $productId];

    $rows = $connection->myData($query, $params);

    if ($rows) {
        $product = $rows[0];
        $brandName = $product['productBrand'];
        $productName = $product['productName'];
        $shade = $product['productShade'];
        $size = $product['productSize'];
        $price = $product['productPrice'];
    } else {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Invalid Product ID!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Smart Tester Info</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffff;
            color: #555;
            line-height: 1.6;
        }

        .wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .logo-container {
            width: 50%;
            background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .logo-container img {
            width: 50%;
            height: auto;
        }

        .content {
            width: 50%;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: rgb(0, 0, 0);
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
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
            background-color: #2c0d51;
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
    <div class="wrapper">
        <div class="content">
            <h1>Modify Product Information</h1>
            <div class="form-container">
                <form method="POST" action="modifySmartTesterInfo.php?id=<?php echo $productId; ?>">
                    <label for="brand-name">Brand Name</label>
                    <input type="text" id="brand-name" name="brand-name" value="<?php echo isset($brandName) ? $brandName : ''; ?>" required>

                    <label for="product-name">Product Name</label>
                    <input type="text" id="product-name" name="product-name" value="<?php echo isset($productName) ? $productName : ''; ?>" required>

                    <label for="shade">Shade</label>
                    <input type="text" id="shade" name="shade" value="<?php echo isset($shade) ? $shade : ''; ?>">

                    <label for="size">Size</label>
                    <input type="text" id="size" name="size" value="<?php echo isset($size) ? $size : ''; ?>" required>

                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" value="<?php echo isset($price) ? $price : ''; ?>" min="0" required>

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="logo-container">
            <img src="css/logo.png" alt="Logo">
        </div>
    </div>

    <div id="myModal" class="popup">
        <h2>Product updated successfully!</h2>
        <button id="okBtn">OK</button>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $updatedBrandName = $_POST['brand-name'];
        $updatedProductName = $_POST['product-name'];
        $updatedShade = $_POST['shade'];
        $updatedSize = $_POST['size'];
        $updatedPrice = $_POST['price'];

        $updateQuery = "UPDATE products SET productBrand = :brandName, productName = :productName, productShade = :shade, productSize = :size, productPrice = :price WHERE productID = :id";

        $params = [
            ':brandName' => $updatedBrandName,
            ':productName' => $updatedProductName,
            ':shade' => $updatedShade,
            ':size' => $updatedSize,
            ':price' => $updatedPrice,
            ':id' => $productId
        ];

        $connection->command($updateQuery, $params);

        echo "<script>
                var modal = document.getElementById('myModal');
                var okBtn = document.getElementById('okBtn');

                modal.style.display = 'block';

                okBtn.onclick = function() {
                    modal.style.display = 'none';
                    window.location.href = 'showAllSmartTester.php';
                }
              </script>";
    }
    ?>
</body>
</html>
