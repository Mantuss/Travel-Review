 <?php 
$BrowTitle = "Home";
require('./config.php');
error_reporting(0);

session_start();
if($_SESSION['user'])
{
$email= $_SESSION["user"];
$sqlNew = "SELECT * FROM traveluserdetails WHERE Email = '$email'";
$checkdb = mysqli_query($conn, $sqlNew);
$GreetName = mysqli_fetch_array($checkdb, MYSQLI_ASSOC);
$check = mysqli_num_rows($checkdb);

if($check == 0){
  header("location: ./post_signup.php");
}
}
include("./header.php");
?>

<h5 class="bg-primary" style="padding: 10px; color: white; margin: 0!important;">
  Welcome, <?php echo $GreetName['FirstName'] . " " . $GreetName['LastName']?>
</h5>

 <div id="carouselExampleTouch" class="carousel slide" data-mdb-touch="false">
        <div class="carousel-indicators">
            <button type="button" data-mdb-target="#carouselExampleTouch" data-mdb-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-mdb-target="#carouselExampleTouch" data-mdb-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-mdb-target="#carouselExampleTouch" data-mdb-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://mdbootstrap.com/img/new/slides/041.jpg" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://mdbootstrap.com/img/new/slides/042.jpg" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://mdbootstrap.com/img/new/slides/043.jpg" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>
                        Praesent commodo cursus magna, vel scelerisque nisl consectetur.
                    </p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleTouch"
            data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleTouch"
            data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
        <div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
              <h1 style="color: #fff !important; text-align: center !important;">Recent Post</h1>
              <p style="color: #fff !important; text-align: center !important;">Recent Reviews From Real User</p>
        </div>
    <!-- Recent Reviews Start -->
    <div class="container" style="margin-bottom: 20px;">
        <div class="row">
          <?php
              $sqlQuery="SELECT * FROM travelpost ORDER BY PostID DESC LIMIT 3";
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
              while($ListMainPosts = mysqli_fetch_assoc($GetImgMainRows)){
                echo "<div class='col-md'>
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
                        $email = $_SESSION['user'];
                        $sqlUser = "SELECT * FROM traveluser WHERE UserName = '$email'";
                        $checkdb = mysqli_query($conn, $sqlUser) or die( mysqli_error($conn));
                        $rowFab = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);
                        $check = mysqli_num_rows($checkdb);
                        $UsersID = $rowFab['UID'];
                        $sqlQUERRY = "SELECT * FROM userfav WHERE UID = '$UsersID' AND PostID = '$postIDS'";
                        $checkdb = mysqli_query($conn, $sqlQUERRY) or die( mysqli_error($conn));
                        $rowFev = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);
                        $checkData = mysqli_num_rows($checkdb);
                          if($checkData >= 1)
                          {
                            echo "<a class='btn btn-primary' href='./favorite.php' style='float: right !important;'>Go to favorite</a>";
                          }

                          else
                          {
                        echo "
                        <form method='post' class='formfev'>
                        <input type='text' value='1' hidden name='fav'>
                        <input type='text' value='". $postIDS ."' hidden name='PostID'>
                        <input type='text' value='". $UsersID ."' hidden name='UserID'>
                        <button name='AddFav' class='btn btn-primary' style='float: right !important;'>Add to favorite</button></form>";
                        
                      }
                    }
                      ?>
                      <?php
                    echo "</div>
                  </div>
              </div>";
              }
              }
              
              }
          ?>
        </div>
      </div>
      <?php
         if(isset($_POST["AddFav"]))
                            {
                              $favNum = $_POST["fav"];
                              $postDBID = $_POST["PostID"];
                              $UserDBID = $_POST["UserID"];
                              $sqlCheck = "INSERT INTO `userfav`(`UID`,`PostID`, `isFavourite`) VALUES ('$UserDBID','$postDBID','$favNum')";
                              if(mysqli_query($conn, $sqlCheck)){
                               $URL="./index.php";
                              echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                              };
                              

                              }
      ?>

      <!-- Most Reviewed -->
      <div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
              <h1 style="color: #fff !important; text-align: center !important;">Most Reviewed</h1>
              <p style="color: #fff !important; text-align: center !important;">Some of the popular content</p>
        </div>
    <!-- Recent Reviews Start -->
    <div class="container" style="margin-bottom: 20px;">
        <div class="row">
          <?php
            $array = array();
              $sqlQuery="SELECT PostID, COUNT(PostID) AS MOST_FREQUENT  FROM travelrating GROUP BY PostID ORDER BY COUNT(PostID) DESC LIMIT 3";
              $checkdb = mysqli_query($conn, $sqlQuery) or die( mysqli_error($conn));
              $check = mysqli_num_rows($checkdb);
              while($allrow = mysqli_fetch_assoc($checkdb)){
                $allrowws = $allrow['PostID'];
                $sqlQuery="SELECT * FROM travelpost WHERE PostID = '$allrowws' LIMIT 1";
              $GetRows = mysqli_query($conn, $sqlQuery);
              while($ListPost = mysqli_fetch_assoc($GetRows)){
              
                $postIDS = $allrow["PostID"];
                $sqlImage = "SELECT * FROM travelpostimages WHERE PostID = '$postIDS' LIMIT 1";
                $GetImgRows = mysqli_query($conn, $sqlImage);
                while($ListPosts = mysqli_fetch_assoc($GetImgRows)){
                $ImageID = $ListPosts["ImageID"];
                $sqlImageGet = "SELECT * FROM travelimage WHERE ImageID = '$ImageID' LIMIT 1";
                $GetImgMainRows = mysqli_query($conn, $sqlImageGet);
                while($ListMainPosts = mysqli_fetch_assoc($GetImgMainRows)){
                  echo "<div class='col-md'>
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
                        $sqlMostUser = "SELECT * FROM traveluser WHERE UserName = '$emailMost'";
                        $checkMostdb = mysqli_query($conn, $sqlMostUser) or die( mysqli_error($conn));
                        $rowMostFab = mysqli_fetch_array($checkMostdb,MYSQLI_ASSOC);
                        $checkMData = mysqli_num_rows($checkMostdb);
                        $UsersMostID = $rowMostFab['UID'];
                        $sqlMostQUERRY = "SELECT * FROM userfav WHERE UID = '$UsersMostID' AND PostID = '$postIDS'";
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
                        <button name='AddFav' class='btn btn-primary' style='float: right !important;'>Add to favorite</button></form>";
                        
                      }
                    }
                      ?>
                      <?php
                    echo "</div>
                  </div>
              </div>";
              }
              }
              }
          ?>
      
      <?php
         
        }
      ?>
        </div>
      </div>

      <!-- You may also like -->
      <div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
              <h1 style="color: #fff !important; text-align: center !important;">You may also like.</h1>
              <p style="color: #fff !important; text-align: center !important;">We know what you like :)</p>
        </div>
    <!-- Recent Reviews Start -->
    <div class="container" style="margin-bottom: 20px;">
        <div class="row">
          <?php
              $sqlQuery="SELECT * FROM travelpost ORDER BY RAND() LIMIT 3";
              $GetRows = mysqli_query($conn, $sqlQuery);
              while($ListPost = mysqli_fetch_assoc($GetRows)){
              $postIDS = $ListPost["PostID"];
              $sqlImage = "SELECT * FROM travelpostimages WHERE PostID = '$postIDS' LIMIT 1";
              $GetImgRows = mysqli_query($conn, $sqlImage);
              while($ListPosts = mysqli_fetch_assoc($GetImgRows)){
              $ImageID = $ListPosts["ImageID"];
              $sqlImageGet = "SELECT * FROM travelimage WHERE ImageID = '$ImageID' LIMIT 1";
              $GetImgMainRows = mysqli_query($conn, $sqlImageGet);
              while($ListMainPosts = mysqli_fetch_assoc($GetImgMainRows)){
                echo "<div class='col-md'>
                <div class='card'>
                    <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                      <img
                        src='./img/large/". $ListMainPosts['Path'] ."' 
                        class='img-fluid' style=''
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
                      <a href='./single.php?IDNumber=". $postIDS  ."'class='btn btn-primary'>Read More</a>";

                    if(isset($_SESSION['user'])){
                        $emails = $_SESSION['user'];
                        $sqlaUser = "SELECT * FROM traveluser WHERE UserName = '$emails'";
                        $checkadb = mysqli_query($conn, $sqlaUser) or die( mysqli_error($conn));
                        $rowaFab = mysqli_fetch_array($checkadb,MYSQLI_ASSOC);
                        $checka = mysqli_num_rows($checkadb);
                        $UsersaID = $rowaFab['UID'];
                        $sqlaQUERRY = "SELECT * FROM userfav WHERE UID = '$UsersaID' AND PostID = '$postIDS'";
                        $checksdb = mysqli_query($conn, $sqlaQUERRY) or die( mysqli_error($conn));
                        $rowsFev = mysqli_fetch_array($checksdb,MYSQLI_ASSOC);
                        $checkaData = mysqli_num_rows($checksdb);
                          if($checkaData >= 1)
                          {
                            echo "<a class='btn btn-primary' href='./favorite.php' style='float: right !important;'>Go to favorite</a>";
                          }

                          else
                          {
                        echo "
                        <form method='post' class='formfev'>
                        <input type='text' value='1' hidden name='fav'>
                        <input type='text' value='". $postIDS ."' hidden name='PostID'>
                        <input type='text' value='". $UsersaID ."' hidden name='UserID'>
                        <button name='AddFav' class='btn btn-primary' style='float: right !important;'>Add to favorite</button></form>";
                        
                      }
                    }
                    echo "</div>
                  </div>
              </div>";
              }
              }
              }
          ?>
        </div>
      </div>

<?php

include("./footer.php");

?>


