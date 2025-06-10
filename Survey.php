<?php
header("Content-Type: application/json");

try {
    $pdo = new PDO("sqlite:C:/xampp/htdocs/Talaf/Talaf.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $stmt = $pdo->query("
        SELECT 
            p.productName, 
            COUNT(CASE WHEN s.liked = 'Yes' THEN 1 END) * 100.0 / COUNT(*) AS percentage_liked,
            COUNT(CASE WHEN s.liked = 'No' THEN 1 END) * 100.0 / COUNT(*) AS percentage_not_liked
        FROM Surveys s
        JOIN Products p ON s.productID = p.productID
        WHERE s.tried = 'yes'
        GROUP BY p.productID
    ");

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
