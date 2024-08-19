<?php




?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About us</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: rgb(20, 20, 20);
    }

    .container {
        max-width: 70%;
        margin: 50px auto;
        padding: 20px;
        background-color: rgb(36, 35, 35);
        border-radius: 8px;
        height: 300px;
        box-shadow: 5px 5px 5px skyblue;
        border: 2px solid white;
    }

    h1 {
        text-align: center;
        color: white;
    }

    .photos {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
        border-radius: 8px;
    }

    .photo {
        flex: 1;
        margin: 10px;
        overflow: hidden;
        position: relative;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .photo:hover {
        transform: scale(1.1);
    }

    .photo img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        border: 1px solid rgb(173, 74, 74);
        box-shadow: 1px 1px 1px 1px brown;
    }

    .photo h2 {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        padding: 8px;
        margin: 0;
        text-align: center;
        font-size: 16px;
        font-weight: normal;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .photo:hover h2 {
        opacity: 1;
    }
.button{
    border: 2px solid white;
    padding: 10px 20px;
    width: 50px;
    text-align:center;
    margin-top: 6%;
    border-radius: 10px;
    background-color: black;
    font-weight: bold;
}
.button:hover{
    background-color: rgb(37, 36, 36);
    transform: scale(1.05);
    color: gray;
}

</style>
</head>
<body>

<div class="container">
    <h1>About Us</h1>
    <div class="photos">
        <div class="photo">
            <img src="./bg.jpg" alt="Photo 1">
            <h2>RAJAN-Team Leader</h2>
        </div>
        <div class="photo">
            <img src="./bg.jpg" alt="Photo 2">
            <h2>Mohanraj-Front End</h2>
        </div>
        <div class="photo">
            <img src="./bg.jpg" alt="Photo 3">
            <h2>Rajkumar-Framework</h2>
        </div>
        <div class="photo">
            <img src="./bg.jpg" alt="Photo 4">
            <h2>Rishikanna-Database</h2>
        </div>
        <div class="photo">
            <img src="./bg.jpg" alt="Photo 5">
            <h2>Okesh-Iot</h2>
        </div>
    </div>
    <div class="button"> <a href="./todaypage.html">Exit</a></div>
  
</div>

</body>
</html>
