<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .success-message {
            color: gray;
            font-weight: bold;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        .home-button {
            margin-top: 15px;
            background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
        }

        .home-button:hover {
            background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>

<div class="form-container">
    <?php
    require_once("connection.php");

    if (isset($_GET['id'])) {
        $productID = $_GET['id'];

        $connection = new Connection();

        if (!empty($productID)) {
            $result = $connection->command("DELETE FROM products WHERE productID = :productID", [':productID' => $productID]);
            $result = $connection->command("DELETE FROM Surveys WHERE productID = :productID", [':productID' => $productID]);

            if ($result) {
                echo "<h1>Product Deleted</h1>";
                echo "<p class='success-message'>The product with ID $productID was successfully deleted.</p>";
            } else {
                echo "<h1>Error</h1>";
                echo "<p class='error-message'>Failed to delete the product. Please try again.</p>";
            }
        } else {
            echo "<h1>Error</h1>";
            echo "<p class='error-message'>Invalid product ID. Please try again.</p>";
        }
    } else {
        echo "<h1>Error</h1>";
        echo "<p class='error-message'>No product ID provided. Please go back and try again.</p>";
    }
    ?>
    <button class="home-button">
        <a href="showAllSmartTester.php">Return to Home</a>
    </button>
</div>

</body>
</html>
