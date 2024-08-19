<?php
$userid=$_GET["userid"];
if(isset($_POST['camera'])){
	header("Location:camera.php?userid=".$userid);
}
if(isset($_POST['admin'])){
	header("Location:today.php?userid=".$userid);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
*{
    margin: 0;
    padding: 0;

}

.container{
    background-image: url("images/bg.jpg");
    background: cover;
    width: 100vw;
    height: 100vh;
    
}

.camera, .admin{
    width: 50px;
    height: 50px;
    background-color: #655564;
    padding: 30px;
    border: 5px solid #EEBF4A;
    border-radius: 50%;
    box-shadow: 2px 2px 5px green;
}
.camera  {
    margin-right: 10px;

}
.admin{
    margin-left: 170px;
}

.camera:hover img,
.admin:hover img {
    transform: scale(1.1); /* Increase the size of the icon on hover */
}

.camera{
    background-color: #172021;
}

.camera>img, .admin>img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
h1{
    color: white;
    font-size: 50px;
    text-align: center;
    padding-top: 30px;
    padding-bottom: 20px;
    font-family: 'Courier New', Courier, monospace;
    letter-spacing: 5px;
    box-shadow: 5px 5px 10px orange;
    width: 60%;
    margin: 0 auto;
}
.box{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    width: 400px;
    height: 200px;
    padding: 50px;
    border: 1px solid #218DC0;
    border-radius: 30px;
    margin: 0 auto;
    margin-top: 130px;
    box-shadow: 2px 5px 2px gray;
    background-color: #1E3D46;
    vertical-align: top;
}

figcaption{
    text-decoration: none;
    margin-top: 60px;

    padding: 5px;
    width: 50px;
}
</style>
<body>
<form method="POST">
    <div class="container">
        <h1>WELCOME TO THE LIBRARY</h1>
        <div class="box">
            <button name="camera">
			<figure class="camera">
                <img src="images/camera-solid.svg" alt="">
                <figcaption class="cap">Camera</figcaption>
            </figure></button> 
            <button name="admin">    
            <figure class="admin">
                <img src="images/user-tie-solid.svg" alt="">
                <figcaption class="cap">Admin</figcaption>
            </figure></button>  
        </div>
    </div>
</form>
</body>
</html>