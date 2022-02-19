<?php

// starting a session
session_start();

// error reporting zero so the page does not show any error
error_reporting(0);

   // creating connection with the database
    require("./config.php");
    
    // getting all the information required in a single post from the database
    $ContentID = $_GET['IDNumber'];

    // query to select information from the database based on content id
    $PageQuery = "SELECT * FROM travelpost WHERE PostID = '$ContentID'";
    $GetImgRows = mysqli_query($conn, $PageQuery);
    $ListPosts = mysqli_fetch_assoc($GetImgRows);
    $PageTitle = $ListPosts['Title'];
    $PostMessage = $ListPosts['Message'];
    $PostUser = $ListPosts['UID'];
    $PostDate = $ListPosts['PostTime'];

    // query to select information from the database based on content id
    $PageImageQuery = "SELECT * FROM travelpostimages WHERE PostID = '$ContentID'";

    $GetImgRows = mysqli_query($conn, $PageImageQuery);
    $ListPosts = mysqli_fetch_assoc($GetImgRows);
    $ImageID = $ListPosts["ImageID"];

    // query to select information from the database based on image id
    $PageImageGet = "SELECT * FROM travelimage WHERE ImageID = '$ImageID'";
    $GetImgMainRows = mysqli_query($conn, $PageImageGet);
    
    $ListMainPosts = mysqli_fetch_assoc($GetImgMainRows);

    // query to select information from the database based on postuser
    $UserQuery = "SELECT * FROM traveluserdetails WHERE UID = '$PostUser'";
    $GetUserRows = mysqli_query($conn, $UserQuery);
    $UserList = mysqli_fetch_assoc($GetUserRows);
    $UserFirstName = $UserList['FirstName'];
    $UserSecondName = $UserList['LastName'];

    // query to select information from the database based on image id
    $LocationQuery = "SELECT * FROM travelimagedetails WHERE ImageID = '$ImageID'";
    $GetLocationRows = mysqli_query($conn, $LocationQuery);
    $ImgLocationList = mysqli_fetch_assoc($GetLocationRows);
    $ImgCaption = $ImgLocationList['Description'];

    $BrowTitle = $PageTitle;       

              // including the header of the page
              require_once("./header.php");

?>

<!-- main body of the single post page -->
<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="card">
<h2 style="padding: 10px; text-transform: uppercase;"><?php echo $PageTitle; ?></h2>
<img src="./img/large/<?php echo $ListMainPosts['Path']; ?>" class="img-fluid" alt="..." style="max-height: 500px;" />
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Posted By: <?php echo $UserFirstName . " " . $UserSecondName; ?></a></li>
        <li class="breadcrumb-item"><a href="#">Date & Time: <?php  echo $PostDate; ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Caption: <?php echo $ImgCaption;  ?></a></li>
      </ol>
    </nav>
  </div>
</nav>
<div style="padding: 20px; text-align: justify; "><?php echo $PostMessage; ?></div>
</div>
</div>
<div class="card text-white mb-3 mx-auto" style="max-width: 30rem;">
  <div class="card-header bg-primary">Write a review.</div>
  <div class="card-body" style="color: black !important;">
  <div class="contain">
      <div class="post">
      </div>
  <div class="star-widget">
    <?php 

    // if the user submits the rating for the page
    if(isset($_SESSION['user'])){
      $UserMail = $_SESSION['user'];
    $getUserSql = "SELECT * FROM `traveluserdetails` WHERE Email = '$UserMail' ";
    $checkdb = mysqli_query($conn, $getUserSql);
   $Userrow = mysqli_fetch_array($checkdb, MYSQLI_ASSOC);
     $UserRows =  $Userrow['UID'];
   $sql = "SELECT * FROM `travelrating` WHERE UID = '$UserRows' AND PostID = '$ContentID'";
   $checkdb = mysqli_query($conn, $sql);
   $row = mysqli_fetch_array($checkdb, MYSQLI_ASSOC);
   $check = mysqli_num_rows($checkdb);

   if($check == 1)
   {
     // if the rating is 5
     if($row['Rating'] == 5)
     { 
       $rateNum5 = "Checked";
     }

     // if the rating is 4
     else if($row['Rating'] == 4)
     { 
       $rateNum4 = "Checked";
     }

     // if the rating is 3
     else if($row['Rating'] == 3)
     { 
       $rateNum3 = "Checked";
     }

     // if the rating is 2
     else if($row['Rating'] == 2)
     { 
       $rateNum2 = "Checked";
     }

     // if the rating is 1
     else 
     { 
       $rateNum1 = "Checked";
     }

     // printing the amount of stars in  the page based on rating number
     echo"
        <div style='height: 40px;'>
        <input type='radio' ". $rateNum5 ." name='rate' disabled = 'disabled' id='rate-5'>
        <label for='rate-5' class='fas fa-star'></label>
        <input type='radio' ". $rateNum4 ." name='rate' disabled = 'disabled' id='rate-4'>
        <label for='rate-4' class='fas fa-star'></label>
        <input type='radio' ". $rateNum3 ." name='rate' disabled = 'disabled' id='rate-3'>
        <label for='rate-3' class='fas fa-star'></label>
        <input type='radio' ". $rateNum2 ." name='rate' disabled = 'disabled' id='rate-2'>
        <label for='rate-2' class='fas fa-star'></label>
        <input type='radio' ". $rateNum1 ." name='rate' disabled = 'disabled' id='rate-1'>
        <label for='rate-1' class='fas fa-star'></label>
      </div>
        <form action='#'>
        <div class='form-outline'>
  <textarea class='form-control' id='textAreaExample' rows='4' disabled style='padding-top: 10px;'>". $row["Comments"] ."</textarea>
  <label class='form-label' for='textAreaExample'>Your Review</label>
</div>
            <button class='btn btn-primary reviewbtn' disabled type='submit'>Post</button>
        </form>";
    }

    // if the user has not rated the post yet
    else{
      echo"
      <form method='post'>
      <div style='height: 40px;'>
      <input type='radio' name='rate' value='5' id='rate-5'>
      <label for='rate-5' class='fas fa-star'></label>
      <input type='radio' name='rate' value='4' id='rate-4'>
      <label for='rate-4' class='fas fa-star'></label>
      <input type='radio' name='rate' value='3' id='rate-3'>
      <label for='rate-3' class='fas fa-star'></label>
      <input type='radio' name='rate' value='2' id='rate-2'>
      <label for='rate-2' class='fas fa-star'></label>
      <input type='radio' name='rate' value='1' id='rate-1'>
      <label for='rate-1' class='fas fa-star'></label>
    </div>
      
      <div class='form-outline'>
<textarea name='comment' class='form-control' id='textAreaExample' rows='4' style='padding-top: 10px; margin-bottom: 15px;'></textarea>
<label class='form-label' for='textAreaExample'>Review Message</label>
</div>
          <button class='btn btn-primary reviewbtn' name='submit' type='submit'>Post</button>
      </form>";
    }
  }
  // if the user is not logged in
  else{
    echo"<div class='alert alert-info' role='alert'>
    Please <a href='./login.php'>Login</a> Or <a href='./signup.php' >Signup</a> to review.
  </div>";
  }

  // if the user submits the comment and rating of the post
  if(isset($_POST["submit"]))
      {
        $rate = $_POST["rate"];
        $comment = $_POST["comment"];

        $sql = "INSERT INTO `travelrating`(`UID`, `PostID`, `Comments`, `Rating`) VALUES ('$UserRows','$ContentID','$comment','$rate')";
        mysqli_query($conn,$sql);
        header("location: ./single.php");
      }
        ?>
      </div>
      <?php
        $sqlAvg = "SELECT * FROM travelrating WHERE PostID = '$ContentID'";
        $checkdb = mysqli_query($conn, $sqlAvg);
        $checkAvg = mysqli_num_rows($checkdb);
        $sum = 0;
        $count = 0;

      // filling the star rating based on the rating given by the user
      if($checkAvg >= 1){
        while($rowAvg = mysqli_fetch_assoc($checkdb))
        {
          $sum = $sum + $rowAvg["Rating"];
          $count = $count + 1;
        }
  
        $Average = $sum / $count;
  
        if(round($Average) == 5)
        { 
          $rateNumber5 = "Checked";
        }
   
        else if(round($Average) == 4)
        { 
          $rateNumber4 = "Checked";
        }
   
        else if(round($Average) == 3)
        { 
          $rateNumber3 = "Checked";
        }
        else if(round($Average) == 2)
        { 
          $rateNumber2 = "Checked";
        }
   
        else 
        { 
          $rateNumber1 = "Checked";
        }
      
      ?>
      <hr style="border:3px solid blue;">
      <div class="contain">
      <div class="star-widgets">
      <span class="heading">User Rating</span>
      <div class='rate'>
        <?php
         echo" <input type='radio' id='stars5' name='rates' value='5' ". $rateNumber5 ." disabled = 'disabled'/>
          <label for='stars5' title='text'>5 stars</label>
          <input type='radio' id='stars4' name='rates' value='4' ". $rateNumber4 ." disabled = 'disabled'/>
          <label for='stars4' title='text'>4 stars</label>
          <input type='radio' id='stars3' name='rates' value='3' ". $rateNumber3 ." disabled = 'disabled'/>
          <label for='stars3' title='text'>3 stars</label>
          <input type='radio' id='stars2' name='rates' value='2' ". $rateNumber2 ." disabled = 'disabled'/>
          <label for='stars2' title='text'>2 stars</label>
          <input type='radio' id='stars1' name='rates' value='1' ". $rateNumber1 ." disabled = 'disabled'/>
          <label for='stars1' title='text'>1 star</label>";
     
          ?>
        </div>
      
      
      
      
      </div>
      </div>
      <p><?php echo round($Average,1); ?> average based on <?php echo $count; ?> reviews.</p>

    </div>
    <hr style="border:3px solid blue;">
    <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-reviews">
                    <h5 class="mb-1">All Ratings and Reviews</h5><br>
                    <?php 
                    $allReview = "SELECT * FROM travelrating WHERE PostID = '$ContentID' ORDER BY reviewDate DESC";
                    $checkdb = mysqli_query($conn, $allReview);
                    $checkAll = mysqli_num_rows($checkdb);
                    while($ReviewAll = mysqli_fetch_assoc($checkdb)){
                    $AllUserID = $ReviewAll['UID'];
                    $Reviews = $ReviewAll['Comments'];
                    $ReviewsDate = $ReviewAll['reviewDate'];
                    $reviewQuery = "SELECT * FROM traveluserdetails WHERE UID = '$AllUserID'";
                    $GetReviewRows = mysqli_query($conn, $reviewQuery);
                    while($ListUsers = mysqli_fetch_assoc($GetReviewRows)){
                    $Fname = $ListUsers["FirstName"];
                    $Lname = $ListUsers["LastName"];


                   echo" <div class='reviews-members'>
                        <div class='media'>
                            <div class='media-body'>
                                <div class='reviews-members-header'>
                                    <h6 class='mb-1'><a class='text-black' href='#'>" . $Fname . " " . $Lname ."</a></h6>
                                    <p class='text-gray' style='font-size: 13px; color: gray;'> Posted On: " . $ReviewsDate . "</p>
                                </div>
                                <div class='reviews-members-body'>
                                    <p> " . $Reviews . " </p>
                                </div>
                            </div>
                        </div><hr>";
                        }
              }
                    echo"</div>
                    
                </div>
               
                </div>";
                }
                else{
                echo "<div class='alert alert-info' role='alert'>
                No reviews yet! Be the first to review.
              </div>";
              }
  echo " </div></div></div>";
  ?>

<div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
              <h1 style="color: #fff !important; text-align: center !important;">Related Posts</h1>
              <p style="color: #fff !important; text-align: center !important;">Checkout Some More Posts.</p>
        </div>
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
                      <a href='./single.php?IDNumber=". $postIDS  ."'class='btn btn-primary'>Read More</a>
                    </div>
                  </div>
              </div>";
              }
              }
              
              }
          ?>
        </div>
      </div>
<?php

require_once("./footer.php");
?>