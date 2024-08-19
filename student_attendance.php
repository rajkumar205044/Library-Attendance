<?php
$userid=$_GET["userid"];
$regno=$_GET["regno"];
if(isset($_POST['date'])){
	header("Location:date.php?userid=".$userid);
}
if(isset($_POST['database'])){
	header("Location:database.php?userid=".$userid);
}
if(isset($_POST['today'])){
	header("Location:today.php?userid=".$userid);
}
$data = array();
$data[] = array(
    'date',
    'regno',
    'student name',
    'dept',
    'batch',
    'intime',
    'outtime',
    'duration'
);

$conn = mysqli_connect('localhost','root','hello','library');
$query="select name from students where regno=".$regno;
$student_name=mysqli_fetch_assoc(mysqli_query($conn,$query))['name'];






$html='';
 // Initialize the export data array

    $query = "SELECT * FROM logs WHERE regno='".$regno."'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $reversedRows = array_reverse($rows);
    foreach ($reversedRows as $row) {
    //echo '<script>var today_date='.$row['date'].';</script>';
    // Fetch student details
    $query = "SELECT * FROM students WHERE regno = ".$row['regno'];
    $result_students = mysqli_query($conn, $query);
    if(mysqli_num_rows($result_students)==0){}
    else{
    $row_students = mysqli_fetch_assoc($result_students);
    $student_name=$row_students['name'];
    // Fetch department details
    $query = "SELECT name, year FROM department WHERE id =".$row_students["department"];
    $result_dept = mysqli_query($conn, $query);
    $row_dept = mysqli_fetch_assoc($result_dept);

    $time1 = new DateTime($row['intime']);
    $time2 = new DateTime($row['outtime']);
    
    $interval = $time1->diff($time2);
    
    $timeDiff = $interval->format('%H hr: %I m');

    if($row['outtime']==null){
        $data[] = array(
            $row['date'],
            $row['regno'],
            $student_name,
            $row_dept['name'],
            $row_dept['year'],
            $row['intime'],
            "-",
            "-"
        );
    $html.= "
        <tr>
        <td id='data' ><a style='color: white !important; text-decoration:none; ' href='student_detail.php?regno=".$row['regno']."&userid=".$userid."'>".$row['regno']."</a></td>
            <td id='data'>".$student_name."</td>
            <td id='data'>".$row_dept['name']."</td>
            <td id='data'>".$row_dept['year']."</td>
            <td id='data'>".$row['intime']."</td>
            <td id='data'>-</td>
            <td id='data'>-</td>
        </tr>
    ";}
    else{


        $data[] = array(
            $row['date'],
            $row['regno'],
            $student_name,
            $row_dept['name'],
            $row_dept['year'],
            $row['intime'],
            $row['outtime'],
            $timeDiff
        );



        $html.= "
        <tr>
        <td id='data' ><a style='color: white !important; text-decoration:none; ' href='student_detail.php?regno=".$row['regno']."&userid=".$userid."'>".$row['regno']."</a></td>
            <td id='data'>".$student_name."</td>
            <td id='data'>".$row_dept['name']."</td>
            <td id='data'>".$row_dept['year']."</td>
            <td id='data'>".$row['intime']."</td>
            <td id='data'>".$row['outtime']."</td>
            <td id='data'>".$timeDiff."</td>
        </tr>
    ";
    
    }
}
//<td id='data'>".date_diff(date_create($row['intime']),date_create($row['outtime']))->i."</td>
}














if(isset($_POST["print"])){
    $csv_data='';
    foreach ($data as $row) {
        $csv_data .= implode(',', $row) . "\n";
    }
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$regno."-".$student_name.'.csv"');
echo $csv_data;
exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current_day</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                <h1><?php echo $regno."-".$student_name;?> Full Attendance </h1>
                
                <!--div class="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                    <div class="dropdown-content">
                        <a href="#">Option 1</a>
                        <a href="#">Option 2</a>
                        <a href="#">Option 3</a>
                    </div>
                </div-->
            </div> 
            <div class="table-container">
            <table id="myTable">
                <thead>
                    <tr class="sticky-row">
                        <th>Register Number</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Batch</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>



                <?php
echo $html;

?>
    <textarea id="csvTextArea" rows="10" cols="50"><?php echo $csv_data; ?></textarea>

    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div><form method="post">
            <button class="print"  name="print"><i class="fa-solid fa-print"></i>print</button></form>
        </article> 
        <form method="post">
        <aside>
            <h1 style="text-align: center;" id="menu">MENU</h1><br>
        <nav class="menu">  
            <button style="width: 100%;"  name="today"><h2><i class="fa-solid fa-calendar-week"></i> Today </h2> </button> 
            <button style="width: 100%;"  name="date"><h2><i class="fa-solid fa-calendar-days"></i> Print Attendance</h2></button>
            <button style="width: 100%;" class="current" name="database"><h2><i class="fa-solid fa-database"></i> DataBase</h2></button>
        </nav></form>
        <div class="user">
            <p><?php echo $userid?></p>
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

<script>
        // Function to trigger download of CSV file
        function downloadCSV() {
            // Get CSV data from textarea
            var csvContent = document.getElementById('csvTextArea').value;

            // Create blob with CSV data
            var blob = new Blob([csvContent], { type: 'text/csv' });

            // Create object URL for the blob
            var url = URL.createObjectURL(blob);

            // Create anchor element for download
            var a = document.createElement('a');
            a.href = url;
            a.download = new Date().toISOString().slice(0, 10).replace(/-/g, '')+'.csv';

            // Append anchor to body and trigger click event
            document.body.appendChild(a);
            a.click();

            // Remove anchor from body
            document.body.removeChild(a);

            // Revoke object URL to free up memory
            URL.revokeObjectURL(url);
        }

        // Attach click event listener to download button
        document.getElementById('downloadBtn').addEventListener('click', downloadCSV);
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
<style>
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
#csvTextArea{
        display:none;
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
background-color: darkslategrey;  
transition: background-color 0.3s ease;
transform: scale(1.05);
}
.menu button.current{
background-color: darkslategrey;
color: black;
}
.menu button.current:hover{
    background-color: rgb(42, 71, 71);
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

.dropdown-content a {
color: white;
padding: 12px 16px;
text-decoration: none;
display: block;
border-radius: 2px;
}

.dropdown-content a:hover {
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
    height: 70vh; /* Adjust the height as needed */
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

button {
padding: 10px 20px;
background-color: #fd9644;
color: black;
border: 2px solid #30321C;
border-radius: 10px;
cursor: pointer;
transition: background-color 0.3s;
box-shadow: 2px 2px 4px #12100E;

}


button:hover {
background-color: #555;
transform: scale(1.05);
color: white;

}
i{
padding-right: 5px;
color: black;
width: 20px;
}







</style>



















<style>
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
    height: 45vh; /* Adjust the height as needed */
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







</style>








</body>	
</html>