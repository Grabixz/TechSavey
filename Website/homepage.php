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
        <title>TechSavey | Home</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the lightslider styling file-->
        <link rel="stylesheet" type="text/css" href="lightslider.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
        <!--This link is for the query script file-->
        <script type="text/javascript" src="jquery.js"></script>
        <!--This link is for the lightslider script file-->
        <script type="text/javascript" src="lightslider.js"></script>
    </head>

    <body>
        <!--Navigation bar for the home page-->
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
        <main>
            <br>
            <!--Recently added products for the home page-->
            <?php
                //This is to gather all the products that were recently added but only gathering the first 8 items
                $stmt = $pdo->prepare('SELECT * FROM productInfo ORDER BY productDate DESC LIMIT 8');
                $stmt->execute();
                $recentlyAddedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <label class="title">Recently added</label> 
            <ul id="autoWidth" class="cs-hidden">
                <?php foreach ($recentlyAddedProducts as $product): ?>
                    <!--This is to create a list item for each product that was recently added to the site-->
                    <li class="item">
                        <div class="rec-box">
                            <!--This will display the products image-->
                            <div class="rec-image">
                                <img src="uploaded_img/<?php echo $product['productIMG']; ?> ">
                                <!--This adds an overlay with the "View Product" button so the client to view more information about the product-->
                                <div class="rec-overlay">
                                    <a href="productpage.php?page=product&id=<?=$product['productID']?>" class="view-but">View Product</a>
                                </div>
                            </div>
                            <!--This displays the products name-->
                            <div class="rec-name">  
                                <a><?php echo $product['productName']; ?></a>
                            </div>
                            <!--This displays the products price-->
                            <div class="rec-price">
                                <a>R<?php echo $product['productPrice']; ?></a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <br>
            <!--Category Buttons for the home page-->
            <label class="title">Categories</label>
            <div class="cat-container">
                <!--This is the Cameras button for categories home page-->
                <div class="catbox">
                    <div class="cat-type">
                        <a href="categories.php?buttonValue=Cameras" onclick="setButtonValue('Cameras')" class="cat-link"><i class="fa fa-fw fa-camera"></i> Cameras</a>
                    </div>
                </div>
                <div class="catbox">
                    <!--This is the Cell Phones button for categories home page-->
                    <div class="cat-type">
                        <a href="categories.php?buttonValue=Cell Phones" onclick="setButtonValue('Cell Phones')" class="cat-link"><i class="fa fa-fw fa-mobile"></i> Cell Phones</a>
                    </div>
                </div>
                <div class="catbox">
                    <!--This is the Computers button for categories home page-->
                    <div class="cat-type">
                        <a href="categories.php?buttonValue=Computers" onclick="setButtonValue('Computers')" class="cat-link"><i class="fa fa-fw fa-laptop"></i> Computers</a>
                    </div>
                </div>
                <div class="catbox">
                    <!--This is the TVs & Audio button for categories home page-->
                    <div class="cat-type">
                        <a href="categories.php?buttonValue=<?php echo urlencode('TVs & Audio'); ?>" onclick="setButtonValue('TVs & Audio')" class="drop-link"><i class="fa fa-fw fa-television"></i> TV's & Audio</a>
                    </div>
                </div>
                <div class="catbox">
                    <!--This is the Video Games button for categories home page-->
                    <div class="cat-type">
                        <a href="categories.php?buttonValue=Video Games" onclick="setButtonValue('Video Games')" class="cat-link"><i class="fa fa-fw fa-gamepad"></i> Video Games</a>
                    </div>
                </div>
            </div>
            <br>
            <!--Randomly selected products for the home page-->
            <?php
                //This is to gather all the products that are randomly selected but only gathering 8 items
                $stmt = $pdo->prepare('SELECT * FROM productInfo ORDER BY RAND() LIMIT 8');
                $stmt->execute();
                $recentlyAddedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <label class="title">Randomly Picked Items</label> 
            <ul id="auto" class="hidden">
                <?php foreach ($recentlyAddedProducts as $product): ?>
                    <!--This is to create a list item for each product that was recently added to the site-->
                    <li class="item">
                        <div class="rec-box">
                            <!--This will display the products image-->
                            <div class="rec-image">
                                <img src="uploaded_img/<?php echo $product['productIMG']; ?> ">
                                <!--This adds an overlay with the "View Product" button so the client to view more information about the product-->
                                <div class="rec-overlay">
                                    <a href="productpage.php?page=product&id=<?=$product['productID']?>" class="view-but">View Product</a>
                                </div>
                            </div>
                            <!--This displays the products name-->
                            <div class="rec-name">  
                                <a><?php echo $product['productName']; ?></a>
                            </div>
                            <!--This displays the products price-->
                            <div class="rec-price">
                                <a>R<?php echo $product['productPrice']; ?></a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <br>
            <!--How to get your products for the home page-->
            <label class="title">How to get your Product</label>
            <div class="shop-container">
                <div class="shop-box">
                    <div class="shop-globe">
                        <a><i class="fa fa-fw fa-globe"></i></a>
                    </div>
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
        <script>
            //This is for the recently added slider
            $(document).ready(function() {
                $('#autoWidth').lightSlider({
                    autoWidth:true,
                    loop:true,
                    onSliderLoad: function() {
                        $('#autoWidth').removeClass('cS-hidden');
                    } 
                });  
            });
            //This is for the randomly selected slider
            $(document).ready(function() {
                $('#auto').lightSlider({
                    autoWidth:true,
                    loop:true,
                    onSliderLoad: function() {
                        $('#auto').removeClass('hidden');
                    } 
                });  
            });
        </script>
   </body>
</html>