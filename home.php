<?php 

@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    $user_id = $_SESSION['user_id'];
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>home</title>
</head>
<body>
    
    <div class="containers">
        <div class="profile">
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or 
                die('query failed !');
                
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
                
                if($fetch['image'] == ''){
                    echo '<img src="images/avatar-default.png">';
                }else {
                    echo '<img src="uploaded_img/'.$fetch['image'].'">';
                }

            ?>
            <h3><?php echo $fetch['name']; ?></h3>
            <a href="update-profile.php" class="btn">Update profile</a>
            <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
            <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>
        </div>
    </div>


</body>
</html>