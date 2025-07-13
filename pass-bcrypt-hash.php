<?php
session_start();

$hashed_password = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['password'])) {
    $plain_password = $_POST['password'];
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

    $_SESSION['hash'] = $hashed_password;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_SESSION['hash'])) {
    $hashed_password = $_SESSION['hash'];
    unset($_SESSION['hash']); // Remove after display
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Hash Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(to right, #00b09b, #96c93d);
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background: #ffffffee;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #00b09b;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button[type="submit"], .copy-btn {
            padding: 10px 18px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            background: #00b09b;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button[type="submit"]:hover, .copy-btn:hover {
            background: #008b80;
        }
        .result {
            margin-top: 20px;
            background: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            position: relative;
            word-break: break-all;
        }
        .copy-btn {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .copied-msg {
            margin-top: 10px;
            color: green;
            text-align: center;
            font-weight: bold;
            display: none;
        }
        @media (max-width: 480px) {
            .copy-btn {
                top: auto;
                bottom: 15px;
                right: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔐 BCRYPT Password Hash Generator</h2>
    <form method="post">
        <input type="text" name="password" placeholder="Enter plain password..." required>
        <button type="submit">Generate Hash</button>
    </form>

    <?php if (!empty($hashed_password)): ?>
        <div class="result">
            <code id="hashCode"><?= htmlspecialchars($hashed_password); ?></code>
            <button class="copy-btn" onclick="copyHash()">📋</button>
        </div>
        <div class="copied-msg" id="copiedMsg">✅ Copied to clipboard!</div>
    <?php endif; ?>
</div>

<script>
function copyHash() {
    const hashText = document.getElementById("hashCode").innerText;
    navigator.clipboard.writeText(hashText).then(() => {
        document.getElementById("copiedMsg").style.display = 'block';
        setTimeout(() => {
            document.getElementById("copiedMsg").style.display = 'none';
        }, 2000);
    });
}
</script>

</body>
</html>
