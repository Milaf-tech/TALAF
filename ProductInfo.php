<?php
require_once("connection.php");
$connection = new Connection();

$productID = $_GET['id'];

if (empty($productID)) {
    echo "Product ID is missing!";
    exit;
}

$productDetails = $connection->myData("SELECT productName, productBrand, productPrice, productShade, productSize FROM products WHERE productID = '$productID'");

if (!$productDetails || count($productDetails) == 0) {
    echo "Product not found!";
    exit;
}

$product = $productDetails[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tried = ($_POST['tried'] == 'yes') ? 'yes' : 'No';

    if ($tried === 'yes') {
        $liked = ($_POST['liked'] == 'yes') ? 'Yes' : 'No';
        try {
            $query = "INSERT INTO Surveys (productID, tried, liked) VALUES (:productID, :tried, :liked)";
            $params = [
                ':productID' => $productID,
                ':tried' => $tried,
                ':liked' => $liked
            ];
            $connection->command($query, $params);
            echo "<div class='thank-you-message'>Thank you for your feedback!</div>";
        } catch (Exception $e) {
            echo "<script>console.log('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
      echo "<div class='thank-you-message'>Thank you! We appreciate your time.</div>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            max-width: 1200px;
            margin: 20px;
        }

        .product-container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .product-header {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .product-info p {
            font-size: 1.1em;
            margin-bottom: 12px;
            color: #555;
        }

        .survey-container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .survey-header {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }

        .survey-form {
            text-align: left;
            margin-top: 20px;
        }

        .survey-form h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 10px;
        }

        .survey-form label {
            display: block;
            font-size: 1em;
            color: #555;
            margin-bottom: 8px;
        }

        .submit-button {
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

        .submit-button:hover {
            background-color: #2c0d51;
        }

        .thank-you-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1000;
            width: 80%;
            max-width: 300px;
            display: none;
        }

        @media only screen and (max-width: 768px) {
            .product-header {
                font-size: 1.8em;
            }

            .product-info p {
                font-size: 1em;
            }

            .survey-container {
                width: 90%;
            }

            .submit-button {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="product-container">
        <img src="css\logo.png" class="logo" alt="Logo">
            <h1 class="product-header">Product Details</h1>
            <div class="product-info">
                <p><strong>Brand:</strong> <?php echo $product['productBrand']; ?></p>
                <p><strong>Name:</strong> <?php echo $product['productName']; ?></p>
                <p><strong>Shade:</strong> <?php echo $product['productShade']; ?></p>
                <p><strong>Size:</strong> <?php echo $product['productSize']; ?></p>
                <p><strong>Price:</strong> <?php echo $product['productPrice']; ?> SAR</p>
            </div>
        </div>
    </div>

    <div class="survey-container" id="survey-container">
        <h2 class="survey-header">Survey</h2>
        <form method="POST" class="survey-form">
        
            <div id="tried-question">
                <h3>Did you try the product?</h3>
                <label>
                    <input type="radio" name="tried" value="yes" required onclick="handleTriedAnswer(true)"> Yes
                </label>
                <label>
                    <input type="radio" name="tried" value="No" required onclick="handleTriedAnswer(false)"> No
                </label>
            </div>

            <div id="liked-question" style="display: none;">
                <h3>Did you like the product?</h3>
                <label>
                    <input type="radio" name="liked" value="yes"> Yes
                </label>
                <label>
                    <input type="radio" name="liked" value="No"> No
                </label>
            </div>

            <button type="submit" class="submit-button">Submit Survey</button>
        </form>
    </div>

    <script>
        function handleTriedAnswer(answer) {
            if (answer) {
                document.getElementById('tried-question').style.display = 'none';
                document.getElementById('liked-question').style.display = 'block';
            } else {
                document.querySelector('.survey-form').submit();
                document.getElementById('survey-container').style.display = 'none';
                showThankYouMessage();
            }
        }

        document.querySelector('.survey-form').addEventListener('submit', function () {
            document.getElementById('survey-container').style.display = 'none';
            showThankYouMessage();
        });

        function showThankYouMessage() {
            var thankYouMessage = document.createElement('div');
            thankYouMessage.className = 'thank-you-message';
            thankYouMessage.innerHTML = 'Thank you for your feedback!';
            document.getElementById('product-container').appendChild(thankYouMessage);

            setTimeout(function () {
                thankYouMessage.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>
