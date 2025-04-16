<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

$stmt = $db->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $update = $db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $update->execute([$username, $email, $user_id]);

    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['email'] = $email;

    header("Location: timeline.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil</title>
</head>
<body>
    <h2>Edit Profil</h2>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br><br>
        <button type="submit">Simpan Perubahan</button>
        <a href="timeline.php">Kembali</a>
    </form>
</body>
</html>
