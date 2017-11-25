<?php
// adapted from https://www.w3schools.com/php/php_file_upload.asp
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);
$user = $_COOKIE['uid_yousef'];
$imageFileType = pathinfo(basename($_FILES["photo"]["name"]),PATHINFO_EXTENSION);
$newname = bin2hex(random_bytes(6)) . '.' . $imageFileType;
$target_dir = $MEDIA_DIR;
$target_file = $target_dir . basename($newname);
$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["photo"]["size"] > $MAX_UPLOAD_FILESIZE) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $stmt = $link->prepare("UPDATE `members` SET `profileImage` = ?, `firstName` = ?, `lastName` = ? WHERE id = ?");
        $stmt->bind_param("sssi", $newname, $_POST['firstname'], $_POST['lastname'], $user);
        $stmt->execute();
        header('Location: pprofile.php', true, 302);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
