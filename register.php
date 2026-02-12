<?php 

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image = $_FILES['image'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
    
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND 
    password = '$pass'") or die('query faild');

    if(mysqli_num_rows($select) > 0){
        $message[] = 'user already exist';
    }else{
        if($pass != $cpass) {
        $message[] = 'confirm password not Matched !';
    }elseif($image_size > 2000000){
        $message[] = 'image size is large !';
    }else {
        $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) 
        VALUES('$name', '$email', '$pass', '$image')") or die('query faild');

        if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered is successfully !';
            header('location: login.php');
        }else {
            $message[] = 'registration is faild !';
        }
    }
    
}
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>register</title>
</head>
<body>
    

    <div class="form-container">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <h3>Register Now</h3>
            <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="message">'.$message.'</div>';
                }
            }
            
            ?>
            <input type="text" name="name" required class="box" placeholder="enter username">
            <input type="email" name="email" required class="box" placeholder="enter email">
            <input type="password" name="password" required class="box" placeholder="enter password">
            <input type="password" name="cpassword" required class="box" placeholder="confirm password">
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, /image/png">
            <input type="submit" name="submit" value="register now" class="btn">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>
</html>
