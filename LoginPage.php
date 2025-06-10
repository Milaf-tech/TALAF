<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$db_path = 'Talaf.db';

$error_message = '';

try {
    $db = new PDO("sqlite:" . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['username'];
        $pass = $_POST['password'];

        $query = "SELECT * FROM login WHERE name = :name";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['pass'])) {
            session_start();
            $_SESSION['username'] = $user['name'];
            header("Location: analysis.html");
            exit;
        } else {
            $error_message = 'Incorrect username or password!';
        }
    }
} catch (PDOException $e) {
    $error_message = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }
    .container {
      display: flex;
      flex: 1;
    }
    .left {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f9f9f9;
    }
    .login-box {
      width: 350px;
      text-align: center;
      padding: 30px;
      background-color: #ffffff;
      box-shadow: 0 4px 8px #2c3e50;
      border-radius: 10px;
    }
    .login-box h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }
    .login-box input {
      width: 100%;
      padding: 15px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .login-box button {
      width: 100%;
      padding: 15px;
      background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
      border: none;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    .login-box button:hover {
      background-color:#2c0d51;
    }
    .right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
    }
    .right img {
      max-width: 80%;
      height: auto;
    }
    .register-link {
      display: block;
      margin-top: 15px;
      text-align: center;
    }
    .error-message {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="login-box">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
        <p class="register-link">
          Don't have an account? <a href="sign_in.php">Sign Up Now</a>
        </p>
      </div>
    </div>
    <div class="right">
      <img src="css/logo.png" class="logo" alt="Logo">
    </div>
  </div>
</body>
</html>
