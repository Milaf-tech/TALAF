<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css\style.css">
</head>
<body>

    
    <div class="sidebar">
    <img src="css/logo.png" class="logo" alt="Logo">
        <ul>
        <li><a href="analysis.html" style="color: white;">Dashboard</a></li>
            <li><a href="addSmartTester.php" style="color: white;">Add Smart Tester</a></li>
            <li><a href="showAllSmartTester.php" style="color: white;">Modify Smart Tester</a></li>
            <li><a href="LoginPage.php" style="color: white;">Log Out</a></li>
        </ul>
    </div>

    
    <div class="content">
        <h1>Products</h1>

        <div class="container">
            <?php
            require_once("connection.php");
            require_once("phpqrcode-master/qrlib.php");

            $connection = new Connection();
            $rows = $connection->myData("SELECT productID, productName, productPrice, productShade, productSize, productBrand FROM products");

            foreach ($rows as $r) {
                $id = $r['productID'];
                $name = $r['productName'];
                $brand = $r['productBrand'];
                $price = $r['productPrice'];
                $shade = $r['productShade'];
                $size = $r['productSize'];
                
                $productUrl = "http://192.168.100.22/talaf/ProductInfo.php?id=$id";

                $qrCodeFile = "qrcodes/$id.png";
                QRcode::png($productUrl, $qrCodeFile);

                echo "
                <div class='card'>
                    <a href='ProductInfo.php?id=$id'>
                        <h3>$name</h3>
                        <p><strong>Brand:</strong> $brand</p>
                        <p><strong>Price:</strong> $price SAR</p>
                        <p><strong>Shade:</strong> $shade</p>
                        <p><strong>Size:</strong> $size</p>
                    </a>
                    <a href='modifySmartTesterInfo.php?id=$id' class='edit'>✏️</a>
                    <a href='delete.php?id=$id' class='delete'>🗑️</a>
                    <div class='qrCode' id='qrCode_$id' style='display:block;'>
                        <img src='$qrCodeFile' alt='QR Code'>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>

</body>
</html>
