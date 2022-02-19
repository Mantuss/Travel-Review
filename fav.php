<?php 

// starting the sse
session_start();
require("./config.php");

$session = 2;
$image = 2;

$sql = "SELECT * FROM userfav WHERE UID = $session AND ImageID = $image";
$checkdb = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);
$check = mysqli_num_rows($checkdb);

if($check == 1)
{
  echo "<i class='fa fa-heart' style='font-size:30px;margin:100px;color:red;'> </i>";
}

else
{
  echo "
  <form name='form' id='form' method='post'>
  <input type='text' value='1' hidden name='fav'>
  <i name='submit' class='fa fa-heart' style='font-size:30px;margin:100px;' onclick='favourite()'> </i>
  <input id='submit' type='submit' name='submit' hidden>
  </form>
  ";

  if(isset($_POST["submit"]))
  {
    $favNum = $_POST["fav"];
    $sql = "INSERT INTO `userfav`(`UID`,`ImageID`, `isFavourite`) VALUES ('$session','$image','$favNum')";
    mysqli_query($conn, $sql);
    header("location: ./fav.php");

  }
  
}

?>

<div id="my_map_add" style="width:100%;height:300px;"></div>

<script type="text/javascript">
function my_map_add() {
var myMapCenter = new google.maps.LatLng(41.887437, 12.48866);
var myMapProp = {center:myMapCenter, zoom:12, scrollwheel:false, draggable:false, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("my_map_add"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
marker.setMap(map);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuqtG8XhmKQPGoYpFi9dqZmhZTDWGCxE0&callback=my_map_add"></script>