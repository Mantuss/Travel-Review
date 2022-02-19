<?php

// starting the session
session_start();
$BrowTitle = "Browse Image";

// connection with the database
	require('./config.php');

          // if the user adds the post to add to favorite
         if(isset($_POST["AddFav"]))
                            {
                              // all the post related data are assigned to the variable
                              $favNum = $_POST["fav"];
                              $postDBID = $_POST["PostID"];
                              $UserDBID = $_POST["UserID"];

                              //sql query to insert all the information about the favorite post in the database
                              $sqlCheck = "INSERT INTO `userfav`(`UID`,`PostID`, `isFavourite`) VALUES ('$UserDBID','$postDBID','$favNum')";

                              // if the data has been successfully inserted
                              if(mysqli_query($conn, $sqlCheck)){
                               $URL="./browsepost.php";
                              echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                              };
                              

                              }
  // including the header of the page
  include('./header.php');
	echo"<div class='container' style='margin-top: 20px;'>
    <div class='row'>
      <!-- Gallery item -->";?>
      <?php

              // sql queries to select all the information that should be shown in the browsepost page.
              $sqlQuery="SELECT * FROM travelpost ORDER BY PostID DESC";
              $GetRows = mysqli_query($conn, $sqlQuery);
              while($ListPost = mysqli_fetch_assoc($GetRows)){
              $postIDS = $ListPost["PostID"];
              $UserID = $ListPost["UID"];
              $sqlImage = "SELECT * FROM travelpostimages WHERE PostID = '$postIDS' LIMIT 1";
              $GetImgRows = mysqli_query($conn, $sqlImage);
              while($ListPosts = mysqli_fetch_assoc($GetImgRows)){
              $ImageID = $ListPosts["ImageID"];
              $sqlImageGet = "SELECT * FROM travelimage WHERE ImageID = '$ImageID' LIMIT 1";
              $GetImgMainRows = mysqli_query($conn, $sqlImageGet);

              //iterating an showing every post in the webpage
              while($ListMainPosts = mysqli_fetch_assoc($GetImgMainRows)){
                echo "<div class='col-md-4' style='margin-top: 20px;'>
                <div class='card'>
                    <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                      <img
                        src='./img/large/". $ListMainPosts['Path'] ."' 
                        class='img-fluid'
                      />
                      <a href='#!'>
                        <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                      </a>
                    </div>
                    <div class='card-body'>
                      <h5 class='card-title'>" . $ListPost["Title"] . "</h5>
                      <p class='card-text'>
                        ". substr($ListPost["Message"], 0, 100 ) ."
                      </p>
                      <a href='./single.php?IDNumber=". $postIDS  ."'class='btn btn-primary'>Read More</a>
      ";

        if(isset($_SESSION['user'])){
                        $emailMost = $_SESSION['user'];
                        $sqlMostUser = "SELECT * FROM traveluser WHERE UserName = '$emailMost' LIMIT 1";
                        $checkMostdb = mysqli_query($conn, $sqlMostUser) or die( mysqli_error($conn));
                        $rowMostFab = mysqli_fetch_array($checkMostdb,MYSQLI_ASSOC);
                        $checkMData = mysqli_num_rows($checkMostdb);
                        $UsersMostID = $rowMostFab['UID'];
                        $sqlMostQUERRY = "SELECT * FROM userfav WHERE UID = '$UsersMostID' AND PostID = '$postIDS' LIMIT 1";
                        $checkMostdb = mysqli_query($conn, $sqlMostQUERRY) or die( mysqli_error($conn));
                        $rowMostFev = mysqli_fetch_array($checkMostdb,MYSQLI_ASSOC);
                        $checkMostData = mysqli_num_rows($checkMostdb);
                          if($checkMostData >= 1)
                          {
                            echo "<a class='btn btn-primary' href='./favorite.php' style='float: right !important;'>Go to favorite</a>";
                          }

                          else
                          {
                        echo "
                        <form method='post' class='formfev'>
                        <input type='text' value='1' hidden name='fav'>
                        <input type='text' value='". $postIDS ."' hidden name='PostID'>
                        <input type='text' value='". $UsersMostID ."' hidden name='UserID'>
                        <button name='AddFav' class='btn btn-primary' style='float: right !important;'>Favorite</button></form>";
                        
                      }
                    }
                      ?>
                      <?php
                    echo "  </div></div>
</div>";
}}};
          ?>
      
<?php
	
  // including the footer of the page
	require('./footer.php');
?>