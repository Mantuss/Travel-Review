<?php

  // starting the session 
	session_start();
$BrowTitle = "Browse Image";
  // creating a connection with the database
	require('./config.php');

  // including the header file
  include('./header.php');

  // query for selecting all the travel images from the database
	$sql = "SELECT * FROM travelimage";
	$checkdb = mysqli_query($conn, $sql);
	$check = mysqli_num_rows($checkdb);
	echo"<div class='container-fluid' style='margin-top: 20px;'>
  <div class='px-lg-5'>
    <div class='row'>
      <!-- Gallery item -->";
      // iterating through all the images
      while($rows = mysqli_fetch_assoc($checkdb)){ 
      	$CheckID = $rows['ImageID'];
      	$imageSQL = "SELECT * FROM travelimagedetails WHERE ImageID = '$CheckID' LIMIT 1";
      	$checkdbs = mysqli_query($conn, $imageSQL);
      	$check = mysqli_num_rows($checkdbs);
      	while($ImageDetails = mysqli_fetch_assoc($checkdbs)){
    
    // printing the image details
		echo"
      <div class='col-xl-3 col-lg-4 col-md-6 mb-4'>
        <div class='bg-white rounded shadow-sm'><img src='./img/large/". $rows['Path'] ."' alt='' class='img-fluid card-img-top'>
          <div class='p-4'>
            <h5> <a href='#'' class='text-dark'>" . $ImageDetails['Title'] . "</a></h5>
            <p class='small text-muted mb-0' style='margin-bottom: 20px !important;'>" . $ImageDetails['Description'] . "</p>
            <a href='./imagesingle.php?imageid=" . $ImageDetails['ImageID'] . "'class='btn btn-primary'>View</a>
            <a href='./imagesingle.php?imageid=' class='btn btn-primary' style='float: right !important;'>Favourite</a>
          </div>
        </div>
      </div>

    ";}};
    echo"
  </div></div>
</div>";
	
  // including the footer file
	require('./footer.php');
?>