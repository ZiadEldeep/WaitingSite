<?php
include 'config.php';

// Fetch current content
$result = $conn->query("SELECT * FROM content WHERE id=1");
$content = $result->fetch_assoc();

// Fetch current links
$links_result = $conn->query("SELECT * FROM links WHERE content_id=1");
$links = [];
if ($links_result && $links_result->num_rows > 0) {
    while ($row = $links_result->fetch_assoc()) {
        $links[] = $row;
    }
}

// Fetch the latest uploaded image
$image_result = $conn->query("SELECT filepath FROM Images ORDER BY id DESC LIMIT 1");
$image = $image_result->fetch_assoc();

// Handle form submission to store email in database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notify'])) {
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if the email is not already subscribed
    $check_query = "SELECT * FROM subscribers WHERE email='$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows == 0) {
        // Insert the email into subscribers table
        $insert_query = "INSERT INTO subscribers (email) VALUES ('$email')";
        if ($conn->query($insert_query) === TRUE) {
            echo '<p>Thank you! You have been subscribed successfully.</p>';
        } else {
            echo '<p>Error: ' . $conn->error . '</p>';
        }
    } else {
        echo '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page website</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* .... */
        body,
html {
    margin: 0;
    padding: 0;
    overflow: hidden;
    height: 100%;
    font-family: 'Roboto', sans-serif;

}
@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

#networkCanvas {
    /* background-color: #04364A; */
    display: block;
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    opacity: 1;
  
}
.content {
    position: relative;
    text-align: center;
    top: 50%;
    color: #ffffff;
    transform: translateY(-50%);
        animation: fadeIn 2s ease-in-out;
    
   
}
.header:hover {
    transform: scale(1.05);
}

.header {
    margin-bottom: 20px;
}

.logo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    user-select: none;
    pointer-events: none;
}

.main-content {
    margin-bottom: 20px;
}

form {
    display: inline-block;
}

input[type="email"] {
    padding: 10px;
    border: none;
    border-radius: 5px;
    margin-right: 10px;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background: #007bff;
    color: white;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

.footer {
    margin-top: 20px;
}

.footer img {
    width: 30px;
    height: 30px;
    margin: 0 10px;
}

.footer p {
    margin-top: 10px;
    font-size: 12px;
}
@media (max-width: 768px) {
    body {
        font-size: 14px;
    }
}

/* Styles for mobile phones */
@media (max-width: 480px) {
    body {
        font-size: 12px;
    }
}

        /* ...... */
        body {
            background-color: <?php echo htmlspecialchars($content['background_color']); ?>;
        }
        .logo {
            max-width: 100px;
        }
        .footer {
            text-align: center;
        }
        .footer a {
            display: inline-block;
            margin: 10px;
            text-decoration: none;
        }
        .footer img {
            max-width: 50px;
            max-height: 50px;
        }
    </style>
</head>

<body>
    <canvas id="networkCanvas"></canvas>
    <div class="content">
        <div class="header">
            <?php if ($image): ?>
                <img src="<?php echo htmlspecialchars($image['filepath']); ?>" alt="Logo" class="logo">
            <?php endif; ?>
            <h1><?php echo htmlspecialchars($content['namez']); ?></h1>
            <p><?php echo htmlspecialchars($content['paragraph']); ?></p>
        </div>
        <br>
        
        <div class="footer">
            <h2>We welcome you to contact us</h2>
            <br>
            <?php foreach ($links as $link): ?>
                <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank">
                    <img src="<?php echo htmlspecialchars($link['logo_url']); ?>" alt="<?php echo htmlspecialchars($link['type']); ?> Logo">
                </a>
            <?php endforeach; ?>
        </div>
        <br>
        <div class="main-content">
            <h3>OR Via Gmail</h3>
            <br>
            <form method="POST" action="index.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
                <button type="submit" name="notify">Notify Me</button>
            </form>
        </div>
        <br>
        <p style="text-align: center;">&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($content['namez']); ?>. All rights reserved.</p>
    </div>
    <script src="script.js"></script>
</body>

</html>
