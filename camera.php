<?php

$userid=$_GET["userid"];
if ($_SERVER["REQUEST_METHOD"] == "POST"){
if (isset($_POST["action"]))  {
    $output = exec('python app.py');
}
if(isset($_POST["quit"])){
shell_exec("taskkill /im python.exe /f");
header("Location:junc.php?userid=".$userid);}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Camera Page</title>
<script>
        function diableButton() {
            var button = document.getElementById('myButton');
            button.disabled = true;
            button.innerHTML = 'Clicked!';
        }
    </script>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        text-align: center;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Welcome to the Camera Page</h1>
    <p>Click start button  only once</p>

  <form method='post'>
    <button type='submit' id='myButton' onclick='disableButton()' name='action' >Start</button>
    <button type='submit' name='quit' >Quit</button>
</form>

    
</div>

</body>
</html>
