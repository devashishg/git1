<?php
session_start();
?>

<?php
$usr=$_POST["id"];
$pas=$_POST["pas"];
$a=0;
$connect = mysqli_connect("localhost","root","","erp") or Die("Not Connected");
$command = "SELECT * FROM login";
$query = mysqli_query($connect,$command) or die(mysqli_error($query));

//echo mysqli_num_rows($query);
if(mysqli_num_rows($query) > 0){

  while($row = mysqli_fetch_assoc($query)) {
    //if((strcmp($usr,$row["id"]))==0 and (strcmp($pas,$row["Password"])==0)) {
    if($usr == $row["id"] && $pas == $row["Password"]){
      $a=1;
      $_SESSION["log"] = 1;
    }
  }


  if($a==0){
    header('Location:index.html');
  }
}?>
<html><head><title>DATA</title>
</head><body>
<?php
$command = "SELECT * FROM Student_Record";
$query = mysqli_query($connect,$command) or die(mysqli_error($query));


$output = '
    <center><h1>Student Record</h1></center><hr/><br><br>
        <center><table border="1px"cellpadding="2px" >
          <thead>
            <tr>
               <th width="16%">Photo</th>
               <th width="5%" >ID</th>
               <th width="15%">Student Name</th>
               <th width="15%">Fatherś Name</th>
               <th width="10%">gender</th>
               <th width="5%" >Class</th>
               <th width="9%">DOB</th>
               <th width="15%">Email</th>
               <th width="12%">Contact No.</th>
               <th width="12%">Action Perform</th>
            </tr>
         </thead>
      <tbody>
';
if(mysqli_num_rows($query) > 0)
{
  $output .= "<form action='redirect.php' method='POST' >";
     while($row = mysqli_fetch_assoc($query))
     {
       $idd = $row["id"];
      // $connect = mysqli_connect("localhost","root","","erp") or Die("Not Connected");
       $command = "SELECT * FROM Student_Record WHERE id = '$idd'";
       $query1 = mysqli_query($connect,$command)or die(mysqli_error($query));
        $result = mysqli_fetch_assoc($query1);
          // $ppicture = $result['image'];
          $output .= '<tr >
                          <td><center >'.'<img height="100px" width="100px" src="data:image;base64,'.$row["image"].'"/></center></td>
                          <td><center >'. $row["id"] .'</center></td>
                          <td><center >'. $row["sname"] .'</center></td>
                          <td><center >'. $row["fname"] .'</center></td>
                          <td><center >'. $row["gen"] .'</center></td>
                          <td><center >'. $row["class"] .'</center></td>
                          <td><center >'. $row["dob"] .'</center></td>
                          <td><center >'. $row["email"] .'</center></td>
                          <td><center >'. $row["pc"] .'</center></td>
                          <td><center>
                          <input type="radio" name = "'.$row["id"].'" id = "'.$row["id"].'" value="Select">Select<br />
                          <input type="radio" name = "'.$row["id"].'" id = "'.$row["id"].'" value="Reject">Reject
                          </center>
                        </td>
                      </tr>';
     }
     $output .="<input type='Submit'></form>";
}
else
{
     $output .= '<tr>
                  <td colspan="10">No Data Found</td>
                 </tr>';
}
$output .= '</tbody></table></center></body></html>';
echo $output;

 ?>
