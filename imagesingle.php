 <?php
 session_start();
 require('./config.php');
 error_reporting(0);
 $BrowTitle = "Single Image";
 require('./header.php');
       $ContentID = $_GET['imageid'];

    $PageQuery = "SELECT * FROM travelimage WHERE ImageID = '$ContentID'";
    $GetImgRows = mysqli_query($conn, $PageQuery);
    $ListPost = mysqli_fetch_assoc($GetImgRows);
    $ImagePath = $ListPost['Path'];
    

    $PageImageQuery = "SELECT * FROM travelimagedetails WHERE imageID = '$ContentID'";

    $GetImgRows = mysqli_query($conn, $PageImageQuery);
    $ListPosts = mysqli_fetch_assoc($GetImgRows);
    $ImageID = $ListPosts["ImageID"];
    $ImageTitle = $ListPosts['Title'];
    $ImageDescription = $ListPosts['Description'];
    $ImageLatitute = $ListPosts['Latitude'];
    $ImageLongitide = $ListPosts['Longitude'];
    $ImageCityCode = $ListPosts['CityCode'];
    $ImageCountry = $ListPosts['CountryCodeISO'];

    $CityQuery = "SELECT * FROM geocities WHERE GeoNameID = '$ImageCityCode'";
    $GetCityRows = mysqli_query($conn, $CityQuery);
    $ListCity = mysqli_fetch_assoc($GetCityRows);
    ?>
    <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="card">
<h2 style="padding: 10px; text-transform: uppercase;"></h2>
<img src="./img/large/<?php echo $ListPost['Path']; ?>" class="img-fluid" alt="..." style="max-height: 500px;" />
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Title: <?php echo $ImageTitle; ?></a></li>
        <li class="breadcrumb-item"><a href="#">Description: <?php  echo $ImageDescription; ?></a></li>
      </ol>
    </nav>
  </div>
</nav>
<h3 style="padding: 10px;">More Info</h3>
<div class="container">
  <div class="row">
    <div class="col">
      <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Information</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">City: </th>
      <td><?php echo $ListCity['AsciiName']; ?></td>
    </tr>
     <tr>
      <th scope="row">Longitude: </th>
      <td><?php echo $ImageLongitide;?></td>
    </tr>
    <tr>
      <th scope="row">Latitude: </th>
      <td><?php echo $ImageLatitute;?></td>
    </tr>
    <tr>
      <th scope="row">Country: </th>
      <td><?php echo $ImageCountry;?></td>
    </tr>
  </tbody>
</table>
    </div>
    <div class="col">
      <div id="my_map_add" style="width:100%;height:300px;"></div>
<script type="text/javascript">
function my_map_add() {
var myMapCenter = new google.maps.LatLng(<?php echo $ImageLatitute; ?>, <?php echo $ImageLongitide; ?>);
var myMapProp = {center:myMapCenter, zoom:12, scrollwheel:false, draggable:false, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("my_map_add"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
marker.setMap(map);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuqtG8XhmKQPGoYpFi9dqZmhZTDWGCxE0&callback=my_map_add"></script>
    </div>
  </div>
  </div>
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
    if(isset($_SESSION['user'])){
      $UserMail = $_SESSION['user'];
    $getUserSql = "SELECT * FROM `traveluserdetails` WHERE Email = '$UserMail' ";
    $checkdb = mysqli_query($conn, $getUserSql);
   $Userrow = mysqli_fetch_array($checkdb, MYSQLI_ASSOC);
     $UserRows =  $Userrow['UID'];
   $sql = "SELECT * FROM `travelrating` WHERE UID = '$UserRows' AND ImageID = '$ContentID'";
   $checkdb = mysqli_query($conn, $sql);
   $row = mysqli_fetch_array($checkdb, MYSQLI_ASSOC);
   $checked = mysqli_num_rows($checkdb);

   if($checked >= 1)
   {
     if($row['Rating'] == 5)
     { 
       $rateNum5 = "Checked";
     }

     else if($row['Rating'] == 4)
     { 
       $rateNum4 = "Checked";
     }

     else if($row['Rating'] == 3)
     { 
       $rateNum3 = "Checked";
     }
     else if($row['Rating'] == 2)
     { 
       $rateNum2 = "Checked";
     }

     else 
     { 
       $rateNum1 = "Checked";
     }

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
  else{
    echo"<div class='alert alert-info' role='alert'>
    Please <a href='./login.php'>Login</a> Or <a href='./signup.php' >Signup</a> to review.
  </div>";
  }
  if(isset($_POST["submit"]))
      {
        $rate = $_POST["rate"];
        $comment = $_POST["comment"];

        $sql = "INSERT INTO `travelrating`(`UID`, `ImageID`, `Comments`, `Rating`) VALUES ('$UserRows','$ContentID','$comment','$rate')";
        mysqli_query($conn,$sql);
        header('Location: ./imagesingle.php');
      }
        ?>
      </div>
      <?php
        $sqlAvg = "SELECT * FROM travelrating WHERE ImageID = '$ContentID'";
        $checkdb = mysqli_query($conn, $sqlAvg);
        $checkAvg = mysqli_num_rows($checkdb);
        $sum = 0;
        $count = 0;
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
                    $allReview = "SELECT * FROM travelrating WHERE ImageID = '$ContentID' ORDER BY reviewDate DESC";
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
<?php
require('./footer.php');
?>