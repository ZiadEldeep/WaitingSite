<?php
include 'config.php';

// Handle form submission for updating content
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    $paragraph = $conn->real_escape_string($_POST['paragraph']);
    $namez = $conn->real_escape_string($_POST['namez']);
    $background_color = $conn->real_escape_string($_POST['background_color']);
    // $logo_url = $conn->real_escape_string($_POST['logo_url']);

    $conn->query("UPDATE content SET paragraph='$paragraph', namez='$namez', background_color='$background_color' WHERE id=1");
}

// Handle form submission for adding a new link
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_link'])) {
    $link_type = $conn->real_escape_string($_POST['link_type']);
    $link_url = $conn->real_escape_string($_POST['link_url']);
    $link_logo_url = $conn->real_escape_string($_POST['link_logo_url']);

    $conn->query("INSERT INTO links (type, url, logo_url, content_id) VALUES ('$link_type', '$link_url', '$link_logo_url', 1)");
}

// Handle link update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_link'])) {
    $link_id = $conn->real_escape_string($_POST['link_id']);
    $link_type = $conn->real_escape_string($_POST['link_type']);
    $link_url = $conn->real_escape_string($_POST['link_url']);
    $link_logo_url = $conn->real_escape_string($_POST['link_logo_url']);

    $conn->query("UPDATE links SET type='$link_type', url='$link_url', logo_url='$link_logo_url' WHERE id=$link_id");
}

// Handle link deletion
if (isset($_GET['delete'])) {
    $link_id = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM links WHERE id=$link_id");
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $target_dir = "uploads/";
    // Check if the directory exists, if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $filename = basename($_FILES["image"]["name"]);
            $conn->query("INSERT INTO Images (filename, filepath) VALUES ('$filename', '$target_file')");
            echo "The file ". htmlspecialchars($filename). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch current content
$result = $conn->query("SELECT * FROM content WHERE id=1");

if ($result && $result->num_rows > 0) {
    $content = $result->fetch_assoc();
    $paragraph = htmlspecialchars($content['paragraph']);
    $namez = htmlspecialchars($content['namez']);
    $background_color = htmlspecialchars($content['background_color']);
    $logo_url = htmlspecialchars($content['logo_url']);
} else {
    $paragraph = '';
    $namez = '';
    $background_color = '';
    $logo_url = '';
    if (!$result) {
        echo "Error: " . $conn->error;
    } else {
        echo "No content found.";
    }
}

// Fetch current links
$links_result = $conn->query("SELECT * FROM links WHERE content_id=1");
$links = [];
if ($links_result && $links_result->num_rows > 0) {
    while ($row = $links_result->fetch_assoc()) {
        $links[] = $row;
    }
}

// Fetch uploaded images
$images_result = $conn->query("SELECT * FROM Images");
$images = [];
if ($images_result && $images_result->num_rows > 0) {
    while ($row = $images_result->fetch_assoc()) {
        $images[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h1, h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input[type="text"], form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="color"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        .link-form {
            margin-bottom: 20px;
        }

        .link-form label {
            margin-bottom: 5px;
        }

        .link-form input[type="text"] {
            width: calc(100% - 100px);
            margin-right: 10px;
        }

        .link-form button {
            width: auto;
            padding: 8px;
        }

        .link-actions {
            margin-top: 10px;
        }

        .link-actions a {
            color: #f44336;
            text-decoration: none;
            margin-left: 10px;
        }

        .link-actions a:hover {
            text-decoration: underline;
        }

        .image-list img {
            max-width: 200px;
            display: block;
            margin: 10px auto;
        }

        /* Container for the table */
        .email-table-container {
            margin-top: 20px;
            width: 100%;
            overflow-x: auto;
        }

        /* Style for the table */
        .email-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        /* Header style */
        .email-table th {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Row style */
        .email-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        /* No emails message */
        .no-emails {
            padding: 10px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>

    <form method="POST" action="admin.php">
        <input type="hidden" name="update_content" value="1">

        <label for="paragraph">Update Paragraph:</label>
        <input type="text" id="paragraph" name="paragraph" value="<?php echo $paragraph; ?>">
        <br>

        <label for="namez">Update Namez:</label>
        <input type="text" id="namez" name="namez" value="<?php echo $namez; ?>">
        <br>
        <label for="background_color">Background Color:</label>
    <input type="color" id="background_color" name="background_color" value="<?php echo $background_color; ?>">
    <br>
    <!-- 
        <label for="logo_url">Logo Image URL:</label>
        <input type="text" id="logo_url" name="logo_url" value="<?php echo $logo_url; ?>">
        <br> -->

        <button type="submit">Update Content</button>
    </form>

    <h2>Manage Links</h2>

    <?php foreach ($links as $link): ?>
        <form method="POST" action="admin.php" class="link-form">
            <input type="hidden" name="update_link" value="1">
            <input type="hidden" name="link_id" value="<?php echo $link['id']; ?>">

            <label for="link_type_<?php echo $link['id']; ?>">Link Type:</label>
            <input type="text" id="link_type_<?php echo $link['id']; ?>" name="link_type" value="<?php echo htmlspecialchars($link['type']); ?>" required>
            <br>

            <label for="link_url_<?php echo $link['id']; ?>">Link URL:</label>
            <input type="text" id="link_url_<?php echo $link['id']; ?>" name="link_url" value="<?php echo htmlspecialchars($link['url']); ?>" required>
            <br>

            <label for="link_logo_url_<?php echo $link['id']; ?>">Link Logo URL:</label>
            <input type="text" id="link_logo_url_<?php echo $link['id']; ?>" name="link_logo_url" value="<?php echo htmlspecialchars($link['logo_url']); ?>" required>
            <br>

            <button type="submit">Update Link</button>
            <a href="admin.php?delete=<?php echo $link['id']; ?>" class="delete-link">Delete Link</a>
        </form>
        <div class="link-actions">
            <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank">Preview Link</a>
        </div>
        <hr>
    <?php endforeach; ?>

    <h3>Add New Link</h3>
    <form method="POST" action="admin.php" class="link-form">
        <input type="hidden" name="add_link" value="1">

        <label for="link_type">Link Type:</label>
        <input type="text" id="link_type" name="link_type" required>
        <br>

        <label for="link_url">Link URL:</label>
        <input type="text" id="link_url" name="link_url" required>
        <br>

        <label for="link_logo_url">Link Logo URL:</label>
        <input type="text" id="link_logo_url" name="link_logo_url" required>
        <br>

        <button type="submit">Add Link</button>
    </form>

    <h2>Upload an Image</h2>
    <form method="POST" action="admin.php" enctype="multipart/form-data">
        <label for="image">Select Image:</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Upload Image</button>
    </form>

    <!-- <h2>Uploaded Images</h2>
    <div class="image-list">
        <?php foreach ($images as $image): ?>
            <img src="<?php echo $image['filepath']; ?>" alt="<?php echo $image['filename']; ?>">
        <?php endforeach; ?>
    </div> -->

    <h2>Subscribed Emails</h2>
<div class="email-table-container">
    <?php
    $emails_result = $conn->query("SELECT * FROM subscribers");
    if ($emails_result && $emails_result->num_rows > 0) {
        echo '<table class="email-table">';
        echo '<thead><tr><th>Email</th></tr></thead>';
        echo '<tbody>';
        while ($email = $emails_result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($email['email']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "<p class='no-emails'>No subscribed emails found.</p>";
    }
    ?>
</div>

</body>
</html>
