<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];

    if (empty($newUsername) || empty($newPassword)) {
        die("Both username and password are required.");
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Create connection to SQLite database
    $dbPath = "database.sqlite";

    try {
        $conn = new PDO("sqlite:" . $dbPath);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$newUsername, $hashedPassword]);

        echo "Account created successfully.";
    } catch (PDOException $e) {
        echo "Error creating account: " . $e->getMessage();
    }
} else {
    header("Location: login.html");
    exit;
}
?>
