<?php
$logerr="";
if(isset($_POST['login'])){
	$userid=$_POST["userid"];
	$password=$_POST["password"];
	$conn = mysqli_connect('localhost','root','hello','library');
	if(!$conn){
	$logerr="Error: Unable to connect DBServer";
	}
	else{
		$query = "SELECT * FROM admin WHERE userid='$userid' ";
		$result=mysqli_query($conn,$query);
		if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_assoc($result)){
				if($row["password"]!=$password)
				$logerr= "Password Incorrect";
				else
				header("Location:junc.php?userid=".$userid);
			}
		}
		else{
			$logerr="No such User";
		}
	}
}

?>
<!DOCTYPE html>
<html lang ="en">
<head>
    <meta sharset="UTF=8">
<meta http-equiv="X-UA-compatible" content="IE-edge">
<meta name="viewpart" content="width=device-widt, initial-scale=1.0">
<title> logine form in html and css | codehel</title>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>

*{
margine:0;
padding:0;
box-sizing:border-box;
font-family:"poppins",sans-serif;
}

body{
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
background-image:url(images/space.png);
background-repeat: no-repeat;

height: 100%;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}
 
.wrapper{
width:420px;
background:#00004d;
color:#fff;
border-radius:20px;
padding: 30px 40px;
box-shadow: 10px 10px 20px black;

}

.wrapper h1{
font-size:36px;
text-align:center;}

.wrapper .input-box{
position:relative;
width:100%;
height:50px;
background:;
margin:30px 0;
}

.input-box input{
width:100%;
height:100%;
background: transparent;
border:none;
outline:none;
border:2px solid rgba(255, 255, 255, .2);
border-radius:40px;
font-size:16px;
color:#fff;
padding:20px 45px 20px 20px;
}

.input-box input::placeholder{
color:#fff;
}

.input-box i {
position:absolute;
right:20%;
top:50%;
transform: translatey(-50%);
font-size:20px;}

.wrapper .remember-forget{
display:flex;
justify-content:space-between;
font-size:14.5px;
margin:-15px 0 15px;
}

.wrapper .btn{
width: 100%;
height: 45px;
background: #fff;
border:none;
outline:none;
border-radius:40px;
box-shadow:0 0 10px rgba(0, 0, 0, .1);
cursor:pointerr;
font-size:16px;
color:#333;
font-weight:600;
}

.wrapper .register-link{

font-size:14.5px;
text-align:center;
margine-top:20px 0 15px;
}


.register-link p a {
color:#fff;
text-decoration:none;
font-weigth:600;
}


.register-link p a:hover{
text-decoration:underline;
}

::-ms-input-placeholder{
color: grey;
opacity:2px;.
}
</style>
<body>
<div class="wrapper">



<form method="POST">
<h1>Login</h2>

<div class="input-box">
<input type="text" name="userid" placeholder="Enter your Username" required>
<i class='bx bxs-user'></i>
</div>

<div class="input-box">
<input type="password" name="password" placeholder="Enter your Password" required >
<i class='bx bxs-lock-alt'></i>
</div>

<?php echo "<p>$logerr</p>";?>
<button type="submit" name="login" class="btn">login</button>
</form>


</div>
</body>
</html>