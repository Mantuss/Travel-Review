<?php

include('./config.php');

    session_start();
    $BrowTitle = "Advance Search";
    include_once('./header.php');

    if(isset($_SESSION['user'])){
          echo"<div class='container-fluid bg-primary' style='padding: 50px; margin-bottom: 20px;'>
        <form method='GET' class='row row-cols-lg-auto g-3 align-items-center' action=''>
          <div class='col-12'>
        <select class='form-select' name='FilterTable'>
            <option value='travelpost' name='FilterTable' >Post</option>
            <option value='travelimage' name='FilterTable'>Images</option>
            <option value='geocountries' name='FilterTable'>Country</option>
        </select>
        </div>
        <div class='col-12'>
        <input class='form-control' type='search' name='searchValue'></div>
        <div class='col-12'>
        <input class='btn btn-primary' type='submit' name='search' value='Search'></div>
    </form></div><div class='container'>";

        if(isset($_GET['search'])){
        $search_query = $_GET['searchValue'];
        $tableFilter = $_GET['FilterTable'];
        if($tableFilter == 'geocountries'){
        $sqlQuery = "SELECT * FROM `geocountries` WHERE `CountryName` LIKE '%$search_query%'";
        $checkingdb = mysqli_query($conn, $sqlQuery);
        $debug = mysqli_fetch_array($checkingdb, MYSQLI_ASSOC);
        $check = mysqli_num_rows($checkingdb);
        
        if($check == 0){
            echo("No Result Found.");
        }

        else{
            echo($check . " Result Found With The Search " . $search_query);
            echo("<br />");
            while($rowCountry = mysqli_fetch_assoc($checkingdb)){
            echo $rowCountry['CountryName']; echo(" ");
            echo $rowCountry['Capital'];
            }
             }
        }







        else if($tableFilter == 'travelpost'){
            $sqlQuery = "SELECT * FROM `travelpost` WHERE `Title` LIKE '%$search_query%' OR `Message` LIKE '%$search_query%'";
        $checkingdb = mysqli_query($conn, $sqlQuery);
        $debug = mysqli_fetch_array($checkingdb, MYSQLI_ASSOC);
        $check = mysqli_num_rows($checkingdb);
        
        if($check == 0){
            echo("No Result Found.");
        }

        else{
            echo($check . " Result Found With The Search " . $search_query);
            echo("<br />");
            while($row = mysqli_fetch_assoc($checkingdb)){
                $PID = $row['PostID'];
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
                            </div>
                          </div>
                      </div> ";
            }
            }
            }

            }
            }
            echo"</div>";
             }
             
        
        else if($tableFilter == 'travelimage'){

            
    echo"<div class='col-md-4 mx-auto' style='margin-top: 20px;'>
    <div class='row'>
      <!-- Gallery item -->";
        $imageSQL = "SELECT * FROM travelimagedetails WHERE `Title` LIKE '%$search_query%' OR `Description` LIKE '%$search_query%'";
        $checkdbs = mysqli_query($conn, $imageSQL);
        $check = mysqli_num_rows($checkdbs);
        if($check == 0){
            echo("No Result Found.");
        }

        else{
            echo($check . " Result Found With The Search " . $search_query);
            echo("<br />");

        while($ImageDetails = mysqli_fetch_assoc($checkdbs)){
        $ImageIDS = $ImageDetails['ImageID'];
        $Queryes = "SELECT * FROM travelimage WHERE ImageID = '$ImageIDS'";
        $checkalldb = mysqli_query($conn, $Queryes);
        $CheckNum = mysqli_num_rows($checkalldb);

        while($ListALL = mysqli_fetch_assoc($checkalldb)){
 
        echo"
        <div class='bg-white rounded shadow-sm'><img src='./img/large/". $ListALL['Path'] ."' alt='' class='img-fluid card-img-top'>
          <div class='p-4'>
            <h5> <a href='#'' class='text-dark'>" . $ImageDetails['Title'] . "</a></h5>
            <p class='small text-muted mb-0' style='margin-bottom: 20px !important;'>" . $ImageDetails['Description'] . "</p>
            <a href='./imagesingle.php?imageid=" . $ImageIDS . "'class='btn btn-primary'>View</a>
          </div>
      </div>

    ";}}};
    echo"
  </div></div>
</div>";
}
    } 

?>

  


<?php
include_once('./footer.php');
    }
    else{
        header("Location: ./login.php");
    }
?>