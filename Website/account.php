<?php
    //This is to include the index page
    include 'index.php';
?>
<!doctype html>
<html>
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA_Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TechSavey | Account</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
   </head>

   <body>
        <!--Navigation bar for the account page-->
        <input id="navbar-indicator" class="navbar-collapse" type="checkbox" checked>
        <nav class="navbar">
            <a class="navbar-logo" href="homepage.php">TechSavey</a>
            <div class="navbar-buttons">
                <a href="search.php" class="nav-link"><i class="fa fa-fw fa-search"></i> Search</a>
                <button onclick="dropdownFunc()" class="nav-butcategory"><i class="fa fa-fw fa-list"></i> Category</button>
                <div class="nav-dropdown">
                    <div id="MyDropdown" class="nav-dropinfo">
                        <a href="categories.php?buttonValue=Cameras" onclick="setButtonValue('Cameras')" class="drop-link"><i class="fa fa-fw fa-camera"></i> Cameras</a>
                        <a href="categories.php?buttonValue=Cell Phones" onclick="setButtonValue('Cell Phones')" class="drop-link"><i class="fa fa-fw fa-mobile"></i> Cell Phones</a>
                        <a href="categories.php?buttonValue=Computers" onclick="setButtonValue('Computers')" class="drop-link"><i class="fa fa-fw fa-laptop"></i> Computers</a>
                        <a href="categories.php?buttonValue=<?php echo urlencode('TVs & Audio'); ?>" onclick="setButtonValue('TVs & Audio')" class="drop-link"><i class="fa fa-fw fa-television"></i> TV's & Audio</a>
                        <a href="categories.php?buttonValue=Video Games" onclick="setButtonValue('Video Games')" class="drop-link"><i class="fa fa-fw fa-gamepad"></i> Video Games</a>
                    </div>
                </div>
                <button onclick="checkaccCookie()" class="nav-butaccount"><i class="fa fa-fw fa-user-circle"></i> Account</button>
                <a onclick="checkcartCookie()" class="nav-link"><i class="fa fa-fw fa-shopping-cart"></i> Cart</a>
                <a href="aboutus.php" class="nav-link"><i class="fa fa-fw fa-info-circle"></i> About Us</a>
            </div>
            <label class="navbar-toggler" for="navbar-indicator"><i class="fa fa-fw fa-navicon fa-lg"></i></label>
        </nav>
        <br>
        <main>
            <?php
                //This is to set the initial value for $userID to an empty string
                $userID = '';

                //This is to check if the cookie userID is set and not an empty string
                if(isset($_COOKIE['userID']) && $_COOKIE['userID'] !== ""){
                    //This is to set the value of $userID to the cookie value
                    $userID = $_COOKIE['userID'];
                } else {
                    //This is to set userID value to the account value. This is if the user didn't select the remember me checkbox
                    $userID = $_GET['account'];
                }
                //This is to find the users information in the table and gather it
                $stmt = $pdo->prepare("SELECT * FROM userInfo WHERE userID = ?");
                $stmt->execute([$userID]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <!--User info for the account page-->
            <div class="container-account">
                <div class="account-profile">
                    <div class="account-user">
                        <a><i class="fa fa-fw fa-user-circle"></i></a>
                    </div>
                    <div class="account-info">
                        <!--Displays the users first name-->
                        <label for="account">First Name: </label><label for="info"><?php echo $row['firstName']; ?></label>
                        <br>
                        <!--Displays the users last name-->
                        <label for="account">Last Name: </label><label for="info"><?php echo $row['lastName']; ?></label>
                        <br>
                        <!--Displays the users email-->
                        <label for="account">Email: </label><label for="info"><?php echo $row['email']; ?></label>
                        <br>
                        <!--Displays the users phone number-->
                        <label for="account">Phone Number: </label><label for="info"><?php echo $row['phoneNum']; ?></label>
                        <br>
                        <?php
                        //This is to check if the cookie exists to see if it should display the logout button or not
                        if (isset($_COOKIE['userID']) && $_COOKIE['userID'] !== '') {
                            echo '<a href="homepage.php" onclick="deleteCookie(\'userID\')" class="logout-link"><i class="fa fa-fw fa-sign-out"></i> Logout</a>';
                        }
                        ?>
                    </div>
                </div>                
            </div>    
            <!--Add or View Product for the account page-->
            <div class="add-product-container">
                <div class="addproduct-profile">
                    <div class="add-product-title">
                        <label>Add and view your products</label>
                    </div>
                    <div class="add-product-info">
                        <label>This is where you can add any of your used or new products onto the site.</label>
                        <br>
                        <label>After adding your product onto the site it will be up for sale. 
                            If there is a user wanting to purchase your item you must bring your product to one of our local branches.
                            You will have up until a week to drop off your product at a local shop otherwise you will be listed for false advertising.
                            Please fill in all necessary information when adding a product to our site.
                        </label>
                    </div>
                    <?php
                        //This is to check if the cookie userID exists to display one of the following buttons
                        if (isset($_COOKIE['userID']) && $_COOKIE['userID'] !== '') {
                            //Cookie exists: Displays the option to go to the add or view product page because they selected remember me on login
                            echo '<br><br>';
                            echo '<div class="add-product-info"><label>Click the button below to proceed with adding the product to the site and viewing your products you have uploaded.</label></div>';
                            echo '<div class="add-product-buttons"><a href="addproduct.php">Click here</a></div>';
                        } else {
                            //Cookie doesn't exist: Displays the option for the user to log in again so they can select remember me option
                            echo '<br><br>';
                            echo '<div class="add-product-info"><label>Select REMEMBER ME to open this page when logging in to view or add a product. Click the button below to do so.</label></div>';
                            echo '<div class="add-product-buttons"><a href="lspage.php">Login Here</a></div>';
                        }
                    ?>
                </div>
            </div>
            <!--Receipts for the account page-->
            <div class="reciept-container">
                <div class="reciept-profile">
                    <div class="recp-product-title">
                        <label>Product Receipts</label>
                    </div>
                    <div class="recp-product-info">
                        <label>This is where you can view all your previously purchased products and the dates they were purchased</label>
                        <br>
                        <label>After purchasing a product on our site, the products you purchased will appear here. After purchasing a product
                            just go to the nearest branch and give your email to one of the workers and they will hand you your purchased product.
                        </label>
                    </div>
                    <?php
                        //This is to check if the cookie userID exists to display one of the following buttons
                        if (isset($_COOKIE['userID']) && $_COOKIE['userID'] !== '') {
                            //Cookie exists: Displays the option to go to the receipts page because they selected remember me on login
                            echo '<br><br>';
                            echo '<div class="recp-product-info"><label>Click the button below to view all your purchased products from our site.</label></div>';
                            echo '<div class="recp-product-buttons"><a href="receipts.php">Click here</a></div>';
                        } else {
                            //Cookie doesn't exist: Displays the option for the user to log in again so they can select remember me option
                            echo '<br><br>';
                            echo '<div class="add-product-info"><label>Select REMEMBER ME to open this page when logging in to view your purchased products. Click the button below to do so.</label></div>';
                            echo '<div class="add-product-buttons"><a href="lspage.php">Login Here</a></div>';
                        }
                    ?>
                </div>
            </div>  
        </main>
        <br>
       <!--Footer for the home page-->
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
    </body>
</html>