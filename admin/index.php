<?php 
require('../config.php');

session_start();
if ($_SESSION['user']) {

    $checkUser = $_SESSION['user'];

    $query = "SELECT * FROM traveluser WHERE UserName = '$checkUser' AND isAdmin = 1";
    
    $checklogin = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($checklogin, MYSQLI_ASSOC);  
    $login = mysqli_num_rows($checklogin);

    if($login == 1){
        if(isset($_POST['submit'])){
    $PostsUpdate = $_POST['PostID'];
    $UpdateQuery = "DELETE FROM `travelrating` WHERE RID = '$PostsUpdate'";
    if(mysqli_query($conn, $UpdateQuery)){
    $URL="./index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    }};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Delete Review</title>
</head>
<body>
    Howdy! <?php echo $row['UserName']; ?>

    <a href="../logout.php">Click Here To Logout</a>

    <?php 
        $sql = "SELECT * FROM travelrating";
        $checkedlogin = mysqli_query($conn, $sql) or die( mysqli_error($conn));
        $Checking = mysqli_num_rows($checkedlogin);

        if($Checking == 0){
            echo "No Reviews Found";
        }
        else{
            echo"<div class='container'><table class='table table-hover'><thead>
    <tr>
      <th scope='col'>RID</th>
      <th scope='col'>Rating</th>
      <th scope='col'>Comments</th>
      <th scope='col'>Action</th>
    </tr>
  </thead>
  <tbody>";
            while($rows = mysqli_fetch_assoc($checkedlogin)){
  
    echo"<tr>
      <td> " . $rows['RID'] . " </td>
   
   
      <td> " . $rows['Rating'] . " </td>
  
      <td> " . $rows['Comments'] . " </td>
   
      <td>  <form method='post' class='formfev'>
                        <input type='text' value='". $rows['RID'] ."' hidden name='PostID'>
                        <button name='submit' class='btn btn-danger'>Remove</button></form> </td>
    </tr>";
  
            }
           echo" </tbody>
</table> </div>";
        }
    ?>

    
</body>
</html>
<?php 
    }
    else{
        header("Location: ../login.php");
    }
} 
else{
   header("Location: ../login.php");
}
?>