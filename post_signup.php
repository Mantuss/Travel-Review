<?php 

// connection with database
require("./config.php");
$BrowTitle = "Complete Your Account Details";
// error_reporting 0 so that no error is shown in tha page
error_reporting(0);
//starting the session
session_start();
$email = $_SESSION["user"];

// query to check if the email is in the database or not
$sqlNew = "SELECT * FROM traveluserdetails WHERE Email = '$email'";
$checkdb = mysqli_query($conn, $sqlNew);
$check = mysqli_num_rows($checkdb);

// if the user information does not exist in the database.
if($check == 0){
// if the user submits the information in the form
if(isset($_POST["submit"]))
{
    // assigning all the values in variables so that it can be stored in the database
    $sql = "SELECT * FROM traveluser WHERE UserName = '$email'";
    $checkdb = mysqli_query($conn, $sql) or die( mysqli_error($conn));
    $row = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);
    $first = $_POST["fname"];
    $last = $_POST["lname"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $region = $_POST["region"];
    $country = $_POST["country"];
    $postal = $_POST["postal"];
    $phone = $_POST["phone"];
    $privacy = 1;
    $ID = $row['UID'];
 
  $sql = "INSERT INTO `traveluserdetails`(`UID`,`FirstName`, `LastName`, `Address`, `City`, `Region`, `Country`, `Postal`, `Phone`,`Email`,`Privacy`) VALUES ('$ID','$first','$last','$address','$city','$region','$country','$postal','$phone','$email','$privacy')";

  // if all the input are successfully stored in the database
  if(mysqli_query($conn,$sql))
  {
    header("location:./index.php");
  }
  
}
// including the header of the page
include_once("./header.php");
?>
// main post_signup body of the page
<div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
        <p style="color: #fff !important; text-align: center !important;">Not <?php echo $email ?>? <a href="./logout.php" style="color: #fff;">Switch Profile</a></p>
        <h1 style="color: #fff !important; text-align: center !important;">Complete Your Profile First</h1>
        <p style="color: #fff !important; text-align: center !important;">You haven't completed your profile yet.</p>
    </div>
    <div class="container">
        <div class="card mx-auto" style="width: 350px; margin-top: 30px; margin-bottom: 70px;">
            <div class="card-body">
                <form method="post">
                    <!-- 2 column grid layout with text inputs for the first and last names -->
                    <div class="row mb-4">

                    <!-- first name input -->
                      <div class="col">
                        <div class="form-outline">
                          <input type="text" id="form6Example1" name="fname" class="form-control" />
                          <label class="form-label" for="form6Example1">First name</label>
                        </div>
                      </div>

                      <!-- last name input -->
                      <div class="col">
                        <div class="form-outline">
                          <input type="text" id="form6Example2" name="lname" class="form-control" />
                          <label class="form-label" for="form6Example2">Last name</label>
                        </div>
                      </div>
                    </div>
                  
                    <!-- address input -->
                    <div class="form-outline mb-4">
                      <input type="text" id="form6Example3" name="address" class="form-control" />
                      <label class="form-label" for="form6Example3">Address</label>
                    </div>
                  
                    <!-- city input  -->
                    <div class="form-outline mb-4">
                      <input type="text" id="form6Example4" name="city" class="form-control" />
                      <label class="form-label" for="form6Example4">City</label>
                    </div>
                  
                    <!-- region input -->
                    <div class="form-outline mb-4">
                      <input type="text" id="form6Example5" name="region" class="form-control" />
                      <label class="form-label" for="form6Example5">Region</label>
                    </div>

                     <!-- country input -->
                    <div class="form-outline mb-4">
                      <input type="text" id="form6Example5" name="country" class="form-control" />
                      <label class="form-label" for="form6Example5">Country</label>
                    </div>

                    <!-- postal code -->
                    <div class="form-outline mb-4">
                      <input type="number" id="form6Example5" name="postal" class="form-control" />
                      <label class="form-label" for="form6Example5">Post Code</label>
                    </div>
                  
                    <!-- Number input -->
                    <div class="form-outline mb-4">
                      <input type="number" id="form6Example6" name="phone" class="form-control" />
                      <label class="form-label" for="form6Example6">Phone</label>
                    </div>
                  
                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Continue</button>
                  </form>

            </div>
        </div>
    </div>
<?php

// including the footer of the page
include_once("./footer.php");
}

// if the user has already filled up the post signup form then the user is redirected to the main page
else{
    
    header("Location: ./index.php");
}
?>


