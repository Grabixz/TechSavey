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
        <title>TechSavey | About Us</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <!--Navigation bar for the about us page-->
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
            <!--Company history for the about us page-->
            <label class="title">TechSavey Company</label>
            <div class="shop-container">
                <div class="shop-box">
                    <div class="shop-globe">
                        <a><i class="fa fa-fw fa-building"></i></a>
                    </div>
                    <div class="shop-info">
                        <label>TechSavey is a family business that started in 2023</label>
                        <label>When ever we have electronic devices we wanted to sell or buy second hand electronic devices we never knew where to 
                            find one. If we did find one we didn't know if they were legitimate or not. This is why we came up with the idea to start
                            our own website to sell new products and used products. To be more safe we will make it that you have to collect the product
                            at one of our branches because we all know how nerve wrecking it can be to meet up with a stranger at a shop to buy their second 
                            hand item.
                        </label>
                    </div>
                </div>
            </div>
            <br>
            <!--How to get your products for the about us page-->
            <label class="title">How to get your Product</label>
            <div class="shop-container">
                <div class="shop-box">
                    <div class="shop-info">
                        <label>Step 1: Login/Signup into your account</label>
                        <br>
                        <label>Step 2: Select what product you want to purchase</label>
                        <br>
                        <label>Step 3: Proceed to checkout on the cart page</label>
                        <br>
                        <label>Step 4: Select one of our branches to collect your product</label>
                        <br>
                        <label>Step 5: After purchase, you can go to your selected branch</label>
                    </div>
                    <div class="shop-globe">
                        <a><i class="fa fa-fw fa-globe"></i></a>
                    </div>
                </div>
            </div>
            <br>
            <!--How to sell your products for the about us page-->
            <label class="title">How to sell your Product</label>
            <div class="shop-container">
                <div class="shop-box">
                    <div class="shop-globe">
                        <a><i class="fa fa-fw fa-shopping-basket"></i></a>
                    </div>
                    <div class="shop-info">
                        <label>Step 1: Login/Signup into your account</label>
                        <br>
                        <label>Step 2: Under the account profile select the "Add and view your Products" button</label>
                        <br>
                        <label>Step 3: Add the products information you want to sell</label>
                        <br>
                        <label>Step 4: Submit the product you want to sell</label>
                        <br>
                        <label>Step 5: After someone has purchased the product, you have a week to drop it off at your local branch</label>
                    </div>
                </div>
            </div>
        </main>
        <br>
        <!--Footer for the about us page-->
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