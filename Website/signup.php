<?php
    //This is to create the connection and to test if it is successful
    $link = mysqli_connect("localhost:3308", "root", "", "TechSavey");
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    //This is to obtain the input information from the html
    $first_name = mysqli_real_escape_string($link, $_REQUEST['sname']);
    $last_name = mysqli_real_escape_string($link, $_REQUEST['slastname']);
    $email = mysqli_real_escape_string($link, $_REQUEST['semail']);
    $phone = mysqli_real_escape_string($link, $_REQUEST['sphone']);
    $password = mysqli_real_escape_string($link, $_REQUEST['spassword']);
    
    //It will loop at a fix number of 5 to find a unique userID so there won't be duplicates
    for($i = 1; $i <= 5; $i++){
        //This is to create the userID
        $pass_one = substr($first_name,0,1);
        $pass_two = substr($last_name,0,1);
        $pass_num = rand(100,999);
        $userID = $pass_one . $pass_two . $pass_num;
 
        //This is to check if the userID exists in the userInfo table
        $check_queryID = "SELECT userID FROM userInfo WHERE userID = '$userID'";
        $userID_result = mysqli_query($link, $check_queryID);
        
        if (mysqli_num_rows($userID_result) == 0){
            break;
            //If the userID doesn't exist, it will exit the loop
        }
    }

    //This is to check if the email account already exists or not in the table of the database
    $check_sql = "SELECT COUNT(*) FROM userInfo WHERE email = '$email'";
    $check_result = mysqli_query($link, $check_sql);
    $check_row = mysqli_fetch_row($check_result);
    $email_count = $check_row[0];
   
    //If the email exists it will go to the if statement and if it doesn't
    //exist it will go to the else statement to insert the information into the table
    if ($email_count > 0) {
        echo "<script> window.location.href='index.html'; alert('Email account already exisits');</script>";   
    }else{
        //This is to insert the information into the table after checking that 
        //the email and userID don't already exist
        $sql = "INSERT INTO userInfo (userID, firstName, lastName, email, phoneNum, pass)
        VALUES ('$userID', '$first_name', '$last_name', '$email', '$phone', '$password')";

        //This is to take the user to the account page after their signup was successful
        if (mysqli_query($link, $sql)){
            echo "<script> window.location.href='LSPage.php'; alert('Welcome, " . $first_name . "! TechSavey would like to thank you for joining us! Please Log in!');</script>";
            exit();
        }
    }
    //This is to close the $link
    mysqli_close($link); 
?>