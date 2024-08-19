<?php
$userid=$_GET["userid"];
echo "<script>var userid='$userid';</script>";
if(isset($_POST['date'])){
	header("Location:date.php?userid=".$userid);
}
if(isset($_POST['database'])){
	header("Location:database.php?userid=".$userid);
}
if(isset($_POST['today'])){
	header("Location:today.php?userid=".$userid);
}

$conn = mysqli_connect('localhost','root','hello','library');
$query = "SELECT * FROM department";
$result=mysqli_query($conn,$query);
$ids=array();
while($row=mysqli_fetch_assoc($result)){
    $ids[]= $row["id"];
}
$message="";
$color="red";
if(isset($_POST['submit'])){
    $regno=$_POST["regno"];
    $photo= addslashes(file_get_contents($_FILES['photo']['tmp_name']));
    if(!$conn){
        echo "Error: Unable to connect DBServer";
    }
    else{
        $query="UPDATE students SET photo='$photo' where regno='$regno' ";
    try{
        $execute=mysqli_query($conn,$query);
        $message="RegNo. " .$regno." updated with New Photo";
        $color="green";
        }
        catch(Exception $e){   
            if($e->getCode()==1062)
            $message="Already registered";
            else
            $message=$e;
            $color="red";
            }
    }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current_day</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./todaypage.css">

</head>


<body onload="initClock">

    <div class="wrapper">
        <header class="header">
            <div class="text">GIT Central Library Attendance Management
            </div>
            <div class="datetime">
                <div class="day" >
                    <div id="time" ><h2 id="current-time" >12:00:00</h2></div>
                        <span id="dayname">day</span>
                        <span id="month">month</span>
                        <span id="daynum">num</span>
                        <span id="year">year</span>
                </div>
            </div>   
           
        </header>
        <article>
		            <div class="admin">
                <h1>Update Photo </h1>
                
                <!--div class="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                    <div class="dropdown-content">
                        <form method="post">
                        <button name="addStudent" >Add Student</button>
                        <button>Option 2</button>
                        <button>Option 3</button>
                    </form>
                    </div>
                </div-->
            </div>
			<script>
			function viewDept(id){
			window.location="student.php?userid="+userid+"&department="+id;	
			}
			
			
			</script>
<div class='table-container'>


<div class="container">
        <form id="myForm" method="post" enctype="multipart/form-data">
            <label for="regno">Reg No:</label>
            <input type="text" id="regno" name="regno" required>
            
            <br>
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/webp, image/jpg" required>
            <br>
            <?php
            echo " <p style='background-color: white; color: ".$color."; '> "      .$message. "</p>";
            ?>
            <br>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
    var regno = document.getElementById('regno').value;
    var name = document.getElementById('name').value;
    var photo = document.getElementById('photo').value;
    
    if (!regno || !name || !photo) {
        alert('Please fill in all fields');
        event.preventDefault();
    }
});

    </script>

</div>

        </article>  
        <form method="post">
        <aside>
            <h1 style="text-align: center;" id="menu">MENU</h1><br>
        <nav class="menu">  
            <button style="width: 100%;" name="today"><h2><i class="fa-solid fa-calendar-week"></i> Today </h2> </button> 
            <button style="width: 100%;" name="date"><h2><i class="fa-solid fa-calendar-days"></i> Print Attendance</h2></button>
            <button style="width: 100%;" class="current" name="database"><h2><i class="fa-solid fa-database"></i> DataBase</h2></button>
        </nav>
		</form>
        <div class="user">
            <p>admin name</p>
        </div>
        <div class="button">
            <button name="about" onclick="goToSecondPage()"><i class="fa-solid fa-circle-info"></i></button>
        </div>
        <script>
            function goToSecondPage() {
                window.location.href = "./about.html";
            }

</script>
        </aside>
      </div>
     
      <script>
        let time = document.getElementById("current-time");
        setInterval(() =>{
        let d = new Date();
        time.innerHTML = d.toLocaleTimeString();
        })
      </script>



<script type="text/javascript">
    function updateClock(){
        var now = new Date();
        var dname = now.getDay(),
            months = now.getMonth(),
            date = now.getDate(),
            year = now.getFullYear();

        var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        var weeks = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        var ids = ["dayname","month","daynum","year"];
        var values = [weeks[dname], date, month[months], year];
        for (var i=0; i < ids.length; i++){
            document.getElementById(ids[i]).firstChild.nodeValue = values[i];
        }
    }
    function initClock(){
        updateClock();
        window.setInterval(updateClock, 1000);
    }
    initClock(); // call initClock to start the clock
</script>


</body>
<style>


    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-image: url('./darkroom.jpg');
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: #7E6363;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
}

form {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"],
select,
button {
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    width: 100%;
    transition: all 0.3s ease;
}

input{
    background-color: #43766C;
}

input[type="text"]:focus,
input[type="file"]:focus,
select:focus,
button:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

button {
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}





.header {
grid-area: header;
color: #6b654b;
}

article {
grid-area: content;
background-color: #113946;
padding: 10px;
}


.wrapper {
display: grid;
grid-gap: 5px;
grid-template-columns: 1fr 3fr;
grid-template-areas: 
"header  header"
"sidebar content"
"footer  footer";
}
@media (max-width: 500px) {
.wrapper {
grid-template-columns: 4fr;
grid-template-areas:
"header"
"content"
"sidebar"
"footer";
}
}
.table-container{
    height: 70vh; /* Adjust the height as needed */
    overflow: auto;
}

                           /*----------------------------HEADER-------------------*/



.header {
font-weight: bold;
display: flex;
justify-content: space-around;
}

.header .text{
font-size: 40px;
background-color: #30321C;
padding: 20px;
text-shadow: 3px 3px 5px black;
border-radius: 5px;
border: 2px solid #6b654b;
width: 81%;
text-align: center;
}

.datetime{
border: 2px solid #6b654b;
border-radius: 5px;
width: 15%;
text-align: center;
background-color: #30321C;
}
#current-time{
    color: white; 
    text-align: center;
}
#dayname, #month, #daynum, #year{
    color: white;
}
.day{
    padding-bottom: 20px;
}






/*-----------------------------------------------------------------------SIDEBAR--------------------------------------------------*/




aside {
background-color: #30321c;
padding: 20px;
width: 300px;
position: relative;
height: 74vh;
border: 2px solid #6b654b;
border-radius: 5px;
}

h2 {
color: black;
text-align: left;
margin-bottom: 20px;
}



aside #menu{
background-color: #4a4b2f;
width: 100px;
text-align: center;
border-radius: 14px;
padding: 10px;
margin: 0 auto;
margin-bottom: 20px;
border: 2px solid #6b654b;
text-shadow: 1px 2px 2px darkslategrey;
}


.user{
width: 150px;
padding: 1px 10px;
border-radius: 15px;
margin: 110px 0 0 0;
letter-spacing: 1px;
font-size: 20px;
}





.button {
position: absolute;
bottom: 10px;
right: 10px;
}



.button button:hover {
background-color: #6b654b;
transform: scale(1.05);


}

/*----------------------------------------------------------------MAIN ARTICLE-----------------------------------------------------------*/




.admin {
background-color: #fd9644;
color: #12100E;
padding: 10px 20px;
display: flex;
align-items: center;
justify-content: space-between;
margin-bottom: 20px;
border-radius: 5px;
border: 2px solid #30321C;
box-shadow: 3px 3px 5px black;
}

.admin h1 {
margin: 0;
}
.dropdown-content {
display: none;
position: absolute;
background-color: #30321c;
min-width: 160px;
box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
z-index: 1;
right: 0;
}

.dropdown-content button {
color: white;
padding: 12px 16px;
text-decoration: none;
display: block;
border-radius: 2px;
width: 100%;
}

.dropdown-content button:hover {
background-color: #fd9644;
color: black;
transform: scale(1.05);

}

.dropdown:hover .dropdown-content {
display: block;
}

.dropdown i {
font-size: 1.5em;
}

article {
padding: 20px;
border: 2px solid #6b654b;
border-radius: 5px;

}


table {
width: 100%;
border-collapse: collapse;
}

th, td {
border: 2px solid #12100E;
padding: 5px;
text-align: center;
color: white;
}
#reg{
    color: orange;
}
th {
background-color: #9B9865;
font-weight: bold;
color: black;
}

.table-container{
    height: 65vh; /* Adjust the height as needed */
    overflow: auto;
}
.sticky-row {
    position: sticky;
    top: 0;
    background-color: #fff;
  }

.print {
flex: 1;
float: right;
margin-top: 6%;
margin-right: 10px;
margin-bottom: 10px;
}


i{
padding-right: 5px;
color: black;
width: 20px;
}


























.header {
grid-area: header;
color: #6b654b;
background-color: black;
}

article {
grid-area: content;
background-color: #113946;
padding: 10px;
}


.wrapper {
display: grid;
background-color: black;
grid-gap: 5px;
grid-template-columns: 1fr 3fr;
grid-template-areas: 
"header  header"
"sidebar content"
"footer  footer";
}
@media (max-width: 500px) {
.wrapper {
grid-template-columns: 4fr;
grid-template-areas:
"header"
"content"
"sidebar"
"footer";
}
}


                           /*----------------------------HEADER-------------------*/



.header {
font-weight: bold;
display: flex;
justify-content: space-around;
}

.header .text{
font-size: 40px;
background-color: #30321C;
padding: 20px;
text-shadow: 3px 3px 5px black;
border-radius: 5px;
border: 2px solid #6b654b;
width: 81%;
text-align: center;
}

.datetime{
border: 2px solid #6b654b;
border-radius: 5px;
width: 15%;
text-align: center;
background-color: #30321C;
}
#current-time{
    color: white; 
    text-align: center;
}
#dayname, #month, #daynum, #year{
    color: white;
}
.day{
    padding-bottom: 20px;
}






/*-----------------------------------------------------------------------SIDEBAR--------------------------------------------------*/




aside {
background-color: #30321c;
padding: 20px;
width: 300px;
position: relative;
height: 74vh;
border: 2px solid #6b654b;
border-radius: 5px;
}

h2 {
color: black;
text-align: left;
margin-bottom: 20px;
}
aside #menu{
background-color: #4a4b2f;
width: 100px;
text-align: center;
border-radius: 14px;
padding: 10px;
margin: 0 auto;
margin-bottom: 20px;
border: 2px solid #6b654b;
text-shadow: 1px 2px 2px darkslategrey;
}
.user{
width: 150px;
padding: 1px 10px;
border-radius: 15px;
margin: 110px 0 0 0;
letter-spacing: 1px;
font-size: 20px;
}




.menu button:hover
{
background-color: #fd9644;  
transition: background-color 0.3s ease;
transform: scale(1.05);
}
.menu button.current{
background-color: #fd9644;
color: black;
}
.menu button.current:hover{
    background-color: #fd9644;
}
button {
padding: 10px 20px;
background-color: darkslategrey;
color: black;
border: 2px solid #30321C;
border-radius: 10px;
cursor: pointer;
transition: background-color 0.3s;
box-shadow: 2px 2px 4px #12100E;

}

.button {
position: absolute;
bottom: 10px;
right: 10px;
}



.button button:hover {
background-color: #6b654b;
transform: scale(1.05);
background-color: #fd9644;


}

/*----------------------------------------------------------------MAIN ARTICLE-----------------------------------------------------------*/
article {
        padding: 20px;
        border: 2px solid #6b654b;
        border-radius: 5px;
    
    }

div.polaroid {

  width: 70%;
  padding: 30px; 30px 30px 30px;
  background-color: #ffe4b3;
  border-radius:20px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 25px;
  margin-left: auto;
  margin-right: auto;
}

span {

align: right;


}

span button{

background-color: #fd9644;
padding: 10px 10px 10px 10px;
color: black;

}





</style>
</html>