<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SellManage</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <!-- Judul -->
            <h1>SellManage</h1>
            <p class="login-subtitle">
                Silakan login untuk melanjutkan
            </p>

            <!-- Pesan Error -->
            <?php if (isset($_SESSION['pesan_error'])): ?>

                <div class="alert-error">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                </div>

                <?php unset($_SESSION['pesan_error']); ?>

            <?php endif; ?>

            <!-- Form Login -->
            <form action="proses_login.php" method="POST">

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="btn-login">
                    Login
                </button>

            </form>

        </div>

    </div>

</body>

</html>