<?php 

// checking the connection of database
require("./config.php");
$BrowTitle = "Login To Your Account";
// error report so that it error is not shown
error_reporting(0);
//initializng the session
session_start();

// if the user has already logged in then it redirects to the main page
if($_SESSION['user'])
{
    header("location: ./index.php");
}

else
{
    // if the user submits the login information
    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM traveluser WHERE UserName = '$email' AND Pass = '$password'";
        $checkdb = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);
        $check = mysqli_num_rows($checkdb);

        // if the user name and password matches that of in database table
        if($check == 1)
        {   
            // making a session for the user
            $_SESSION['user'] = $row['UserName'];
            // redirecting it to post signup
            header("Location: ./post_signup.php");
        }

        else
        {
            $alert = "<div class='alert alert-danger d-flex align-items-center' role='alert'>
  <div>
    An example alert with an icon
  </div>
</div>";
        }
    }

}


// for the header of the page
require("./header.php");

?>
// main login page body
<div class="container-fluid bg-primary" style="padding: 50px; margin-bottom: 20px;">
        <h1 style="color: #fff !important; text-align: center !important;">Secure Client Login</h1>
        <p style="color: #fff !important; text-align: center !important;">This Page Is Restricted!</p>
    </div>
    <div class="container">
        <div class="card mx-auto" style="width: 350px; margin-top: 30px; margin-bottom: 70px;">
            
            <div class="card-body">
                <?php echo $alert; ?>
                <form method="post">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="form2Example1" name="email" class="form-control" />
                        <label class="form-label" for="form2Example1">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="form2Example2" name="password" class="form-control" />
                        <label class="form-label" for="form2Example2">Password</label>
                    </div>

                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example3" />
                                <label class="form-check-label" for="form2Example3"> Remember me </label>
                            </div>
                        </div>

                        <div class="col">
                            <!-- Simple link -->
                            <a href="./forgetpassword.php/">Forgot password?</a>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary reviewbtn">Log me in</button>

                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Not a member? <a href="./signup.php">Register</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php

// for the footer of the page
require("./footer.php");

?>