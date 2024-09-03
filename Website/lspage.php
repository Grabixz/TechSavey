<?php
    //This is to include the index page because it needs the session_start()
    include 'index.php';
    //This is to delete the cart array so that the cart is cleared when a different user logs in
    unset($_SESSION['cart']);

    //This creates the connection to the database TechSavey
    $link = mysqli_connect("localhost:3308", "root", "", "TechSavey");
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }   

    //This is to check if the Loginbtn is pressed.
    if(isset($_GET['Loginbtn'])){
        //This is to obtain the information from the inputs into the varibles that contain $
        $email = mysqli_real_escape_string($link, $_REQUEST['lemail']);
        $password = mysqli_real_escape_string($link, $_REQUEST['lpassword']);

        //This is the sql statement that checks if the email and password match in the userInfo table
        $sql = "SELECT * FROM userInfo WHERE email = '$email' AND pass = '$password'";   
        $result = mysqli_query($link, $sql);

        if($result){
            if(mysqli_num_rows($result) > 0){
                //This is to obtain the userID in the database of the table
                $row = mysqli_fetch_assoc($result);
                $userID = $row['userID'];
                $value = $userID;

                //This checks if the checkbox 'rememberme' was checked or not
                if(!empty($_GET['rememberme'])){
                    //If it was checked it will create the userID cookie with their userID as the cookies value and take them to the account page
                    echo '<script> document.cookie = "userID=' . $value . '; expires=Thu, 01 Jan 2030 00:00:00 UTC; path=/"; </script>';
                    echo '<script> window.location.href = "account.php" </script>';
                } else{
                    //If it wasn't checked it will destroy the userID cookie and take them to the account page
                    echo '<script> document.cookie = "userID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;</script>';
                    echo '<script> window.location.href = "account.php?account=' . $value . '" </script>';
                }
            } else{
                // Redirect to login page and display error message
                echo '<script>alert("Email or Password is incorrect or doesnt exist!"); window.location.href = "lspage.php"</script>';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TechSavey | Login/Signup</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="lspage.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
    </head>

    <body>
        <!--Navigation bar for the login page-->
        <nav class="navbar">
            <a class="navbar-logo" href="homepage.php">TechSavey</a>
        </nav>
        <br>
        <!--Login and Signup Forms-->
        <main>
            <div class="container">
                <div class="forms">
                    <!--Login Form-->
                    <div class="form login">
                        <span class="title">Login</span>
                        <form action="lspage.php" method="get" id="login-form">
                            <!--Email Input-->
                            <div class="input-field">
                                <input type="email" name="lemail" placeholder="Enter your email" required>
                            </div>
                            <!--Password Input-->
                            <div class="input-field">
                                <input type="password" name="lpassword" placeholder="Enter your password" required>
                            </div>
                            <!--Remember Me Checkbox-->
                            <div class="checkbox-text">
                                <div class="checkbox-content">
                                    <input type="checkbox" name="rememberme" id="logCheck">
                                    <label for="logCheck" class="text">Remember me</label>
                                </div>
                            </div>
                            <!--Login Button-->
                            <div class="input-field button">
                                <input type="submit" name="Loginbtn" value="Login">
                            </div>
                        </form>
                        <!--Signup Link to Signup Page-->
                        <div class="login-signup">
                            <span class="text">Not a member?
                                <a href ="#" class="signup-link">Signup Now</a>
                            </span>
                        </div>
                    </div>
                    <!--Registration Form-->
                    <div class="form signup">
                        <span class="title">Registration</span>
                        <form action="signup.php" method="get">
                            <!--First Name Input-->
                            <div class="input-field">
                                <input type="text" name="sname" placeholder="Enter your name" required>
                            </div>
                            <!--Last Name Input-->
                            <div class="input-field">
                                <input type="text" name="slastname" placeholder="Enter your surname" required>
                            </div>
                            <!--Email Input-->
                            <div class="input-field">
                                <input type="email" name="semail" placeholder="Enter your email" required>
                            </div>
                            <!--Phone Number Input-->
                            <div class="input-field">
                                <input type="text" name="sphone" placeholder="Enter your phone no." required>
                            </div>
                            <!--Password Input-->
                            <div class="input-field">
                                <input type="password" name="spassword" placeholder="Enter your password" required>
                            </div>
                            <!--Signup Button-->
                            <div class="input-field button">
                                <input type="submit" value="Signup">
                            </div>
                        </form>
                        <!--Login Link to Login Page-->
                        <div class="login-signup">
                            <span class="text">Already a member?
                                <a href="#" class="login-link">Login Now</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <br>
        <!--Footer for the login page-->
        <footer>
            <div class="content">
                <!--Top Section of the footer-->
                <div class="top">
                    <!--Company Logo-->
                    <div class="logo-details">
                        <img src="IMAGES/Logo.png">
                        <span class="logo-name">TechSavey</span>
                    </div>
                    <!--Company Socials-->
                    <div class="media-icons">
                        <a href="https://www.instagram.com/" target="_blank"><i class="fa fa-fw fa-instagram"></i></a>
                        <a href="https://www.facebook.com/" target="_blank"><i class="fa fa-fw fa-facebook"></i></a>
                        <a href="https://twitter.com/?lang=en" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
                        <a href="https://www.youtube.com/" target="_blank"><i class="fa fa-fw fa-youtube-play"></i></a>
                    </div>
                </div>
                <!--Bottom Section of the footer-->
                <div class="bottom-details">
                    <div class="bottom-text">
                        <!--Company Terms and Conditions and their Copyright-->
                        <span class="copy-text">Copyright @ 2023 <a>TechSavey.</a>All rights reserverd</span>
                        <span class="policy-term">
                            <a>Privacy Policy</a>
                            <a>Terms & Condition</a>
                        </span>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            //This is to wait for the DOM to be fully loaded
            document.addEventListener("DOMContentLoaded", () => {
                //This is to add the active class to the nav item that is clicked
                const container = document.querySelector(".container"),
                signUp = document.querySelector(".signup-link"),
                login = document.querySelector(".login-link");

                //This is when the sign up link is clicked, it will add the "active" class to the container element
                signUp.addEventListener("click", () => {
                    container.classList.add("active");
                });

                //This is when the login link is clicked, it will remove the "active" class from the container element
                login.addEventListener("click", () => {
                    container.classList.remove("active");
                });
            });
        </script>
    </body>
</html>