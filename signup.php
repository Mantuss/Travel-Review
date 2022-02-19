<?php 

// creating a connection with the database
require("./config.php");
$BrowTitle = "Create A New Account";
error_reporting(0);
session_start();

// if any account is already logged in then it return to the home page
if($_SESSION['user'])
{
    header("location: ./index.php");
}

// if no user is logged in
else 
{
  // if the user sumbits the detail through form
  if(isset($_POST["submit"]))
   {
     // assigning all the info gathered from the user in variables
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['repassword'];
    $state = 1;
    $date = date('Y/m/d h:i:s');
    $out = NAN;

    // if the password is same with confirm password
    if($password == $confirm)
    {
        //query to check is the email already exists in the database or not
        $sql = "SELECT * FROM traveluser WHERE UserName = '$email'";

        $checkdb = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);
        $check = mysqli_num_rows($checkdb);

        // if the email already exists then it throws an error
        if($check == 1)
        {
            $out ="MainError";
        }

        // if the email in fresh then
        else
        {
            // sql query to insert all the user information in the database
            $sql = "INSERT INTO `traveluser`(`UserName`,`Pass`,`State`,`DateJoined`,`DateLastModified`) VALUES ('$email', '$password', '$state','$date','$date')";

            // if the information are all inserted into the database then it shows it was a success
            if(mysqli_query($conn,$sql))
            {
                $out = "Success";
            }

            // if the information is not stored in the database then it throws an error
            else
            {
                $out = "UnknownError";
            }
        }
    }

    // if the password does not matches the confirm password 
    else
    {
        $out = "Error";      
    }
    
   }

}

// including the header of the page
include_once("./header.php");

    // if the all the information are stored in the database then it shows your account has been created
    if($out == "Success")
                {
                    $errorMessage = "<div class='alert alert-success d-flex align-items-center' role='alert'>
  <div>
    Account has been created. <a href='./login.php'> Login Here </a>
  </div>
</div>";             
                }
                // if any information fails to be recorded in the datbase then it throws error
                if($out == "UnknownError")
                {
                     $errorMessage = "<div class='alert alert-info d-flex align-items-center' role='alert'>
  <div>
    Opps! Something went wrong.
  </div>
</div>";  
                }
                // throwing error if the email already exists
                if($out == "MainError")
                {
                     $errorMessage = "<div class='alert alert-info d-flex align-items-center' role='alert'>
  <div>
    You already have account:<a href='./login.php'> Login Here</a>
  </div>
</div>";
                }
                
                // throwing error if the password does not match the confirm password
                if($out == "Error")
                {
                     $errorMessage = "<div class='alert alert-danger d-flex align-items-center' role='alert'>
  <div>
    Please enter same password.
  </div>
</div>";
                }

?>
<!-- main body of the siqnup page -->
<div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
        <h1 style="color: #fff !important; text-align: center !important;">Register</h1>
        <p style="color: #fff !important; text-align: center !important;">Create a new account!</p>
    </div>
    <div class="container">
        <div class="card mx-auto" style="width: 350px; margin-top: 30px; margin-bottom: 70px;">
            <div class="card-body">
                <?php echo $errorMessage; ?>
                <form method="post">
                    <!-- 2 column grid layout with text inputs for the first and last names -->
                  
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                      <input type="email" id="form3Example3" required name="email" class="form-control" />
                      <label class="form-label" for="form3Example3">Email address</label>
                    </div>
                  
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                      <input type="password" name="password" required="" id="form3Example4" class="form-control" />
                      <label class="form-label" for="form3Example4">Password</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" name="repassword" required="" id="form3Example4" class="form-control" />
                        <label class="form-label" for="form3Example4">Re-Password</label>
                      </div>
                  
                  
                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary reviewbtn">Sign up</button>
                  
                    <!-- Register buttons -->
                    <div class="text-center">
                            <p>Already a member? <a href="./login.php">Login Now</a></p>
                    </div>
                  </form>

            </div>
        </div>
    </div>


            <?php

// including the footer of the page
include_once("./footer.php");
            

?>

