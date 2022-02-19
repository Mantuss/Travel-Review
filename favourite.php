<?php 

	//starting the session
	session_start();

	//creating connection with the database
	require('./config.php');
	$BrowTitle = "Browse Favourites";

	//including the header of the page
	include_once('./header.php');

	// if the user unfavorites the post then the post added in the database will be deleted
	if(isset($_POST['submit'])){
	
	// assiging the info to different variables
	$UsersUpdate = $_POST['UserID'];
	$PostsUpdate = $_POST['PostID'];
	$UpdateQuery = "DELETE FROM `userfav` WHERE UID = '$UsersUpdate' AND PostID = '$PostsUpdate'";
	if(mysqli_query($conn, $UpdateQuery)){
	$URL="./favourite.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
	};
    }

	echo"<div class='container-fluid bg-primary' style='padding: 50px; margin-bottom: 20px;'>
              <h1 style='color: #fff !important; text-align: center !important;''>Your Favourite List</h1>
              <p style='color: #fff !important; text-align: center !important;''>All Your Fevourite Lists :)</p>
        </div><div class='container' style='margin-bottom: 20px;'>
        <div class='row'>";
	if(isset($_SESSION['user'])){
	$emails = $_SESSION['user'];
	$GetUser = "SELECT * FROM traveluser WHERE UserName = '$emails'";
	$checkdqb = mysqli_query($conn, $GetUser);
	$UIDrows = mysqli_fetch_array($checkdqb, MYSQLI_ASSOC);
	$checkEmail = mysqli_num_rows($checkdqb);
		$UIDMainrows = $UIDrows['UID'];
	$sql = "SELECT * FROM userfav WHERE UID = '$UIDMainrows'";
	$checkdb = mysqli_query($conn, $sql);
	$check = mysqli_num_rows($checkdb);
	while($rows = mysqli_fetch_assoc($checkdb)){
	$PID = 	$rows['PostID'];
	$FevQuery = "SELECT * FROM travelpost WHERE PostID = '$PID' LIMIT 1";
	$checkdab = mysqli_query($conn,$FevQuery);
	$checkPosts = mysqli_num_rows($checkdab);
	while($rowsFev = mysqli_fetch_assoc($checkdab)){
	$PostsIDS = $rowsFev['PostID'];
	$TravelPostImages = "SELECT * FROM travelpostimages WHERE PostID = '$PostsIDS' LIMIT 1";
	$checkdbb = mysqli_query($conn,$TravelPostImages);
	$checkingPosts = mysqli_num_rows($checkdbb);
	while($rowsFevs = mysqli_fetch_assoc($checkdbb)){
	$ImageFevID = $rowsFevs['ImageID'];
	$ImageQuery = "SELECT * FROM travelimage WHERE ImageID = '$ImageFevID' LIMIT 1";
	$checkdcb = mysqli_query($conn,$ImageQuery);
	$checkImagesPosts = mysqli_num_rows($checkdcb);
	while($finalfev = mysqli_fetch_assoc($checkdcb)){
		echo "<div class='col-md-4' style='margin-top: 20px;'>
                <div class='card'>
                    <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                      <img
                        src='./img/large/". $finalfev['Path'] ."' 
                        class='img-fluid' style=''
                      />
                      <a href='#!'>
                        <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                      </a>
                    </div>
                    <div class='card-body'>
                      <h5 class='card-title'>" . $rowsFev["Title"] . "</h5>
                      <p class='card-text'>
                        ". substr($rowsFev["Message"], 0, 100 ) ."
                      </p>
                      <a href='./single.php?IDNumber=". $PID  ."'class='btn btn-primary'>Read More</a>
                        <form method='post' class='formfev'>
                        <input type='text' value='". $PID ."' hidden name='PostID'>
                        <input type='text' value='". $UIDMainrows ."' hidden name='UserID'>
                        <button name='submit' class='btn btn-danger' style='float: right !important;'>Remove</button></form>
                    </div>
                  </div>
              </div>";
	}
	}
	}
	}
	}

	// if the user is not logged in then the user will be sent to login page
	else{
		
		header('Location: ./login.php');
	}
	echo"</div>
      </div>
";
	// including the footer of the page
	include_once("./footer.php");
 ?>
