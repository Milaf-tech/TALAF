<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$db_path = 'Talaf.db';

$message = '';

try {
    $db = new PDO("sqlite:" . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $createTableQuery = "CREATE TABLE IF NOT EXISTS login (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE,
        pass TEXT NOT NULL
    )";
    $db->exec($createTableQuery);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['username'];
        $pass = $_POST['password'];

        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO login (name, pass) VALUES (:name, :pass)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':pass', $hashed_password);

        if ($stmt->execute()) {
            $message = "<p style='color: green; text-align: center;'>User registered successfully!</p>";
            header("Location: analysis.html");
            exit;
        } else {
            $message = "<p style='color: red; text-align: center;'>Registration error! Please try again.</p>";
        }
    }
} catch (PDOException $e) {
    $message = "<p style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
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

.register-box {
  width: 350px;
  text-align: center;
  padding: 30px;
  background-color: #ffffff;
  box-shadow: 0 4px 8px rgb(28, 27, 29);
  border-radius: 10px;
}

.register-box h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

.register-box input {
  width: 100%;
  padding: 15px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.register-box button {
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

.register-box button:hover {
  background: linear-gradient(to right,#b0b0b0,rgb(92, 121, 122));
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
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="register-box">
        <h2>Sign In</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <?php echo $message; ?>
        </form>
      </div>
    </div>
    <div class="right">
      <img src="css/logo.png" class="logo" alt="Logo">
    </div>
  </div>
</body>
</html>
