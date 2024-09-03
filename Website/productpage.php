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
        <title>TechSavey | Product</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
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
        <br>
        <main>
            <?php
                //This is to gather the productID that was selected when the user wants to view the product
                if(isset($_GET['id'])){
                    $stmt = $pdo->prepare('SELECT * FROM productInfo WHERE productID = ?');
                    $stmt->execute([$_GET['id']]);
                    //It will then fetch the product from the database and return the result as an array
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);
                    //It will then check if the product exists (array is not empty)
                    if (!$product) {
                        //It will then display the following message if the array is empty
                        exit('Product does not exist!');
                    }
                } else {
                    //It will then display an error message if the product ID does not exist
                    exit('Product does not exist!');
                }
            ?>
            <!--Selected Product view for the product page-->
            <div class="product-wrapper">
                <div class="product-container">
                    <div class="product-image">
                        <!--Selected product image-->
                        <img src="uploaded_img/<?php echo $product['productIMG']; ?>">
                    </div>
                    <div class="product-info">
                        <!--Selected product name-->
                        <a class="name"><?php echo $product['productName']; ?></a>
                        <!--Selected product price-->
                        <a class="price">R<?php echo $product['productPrice']; ?></a>
                        <form action="cartpage.php" method="POST">
                            <!--Selected product ID-->
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <!--This will then check if the user is logged in by remember me. It checks by using the cookie and will direct the user to a certain page-->
                            <input type="button" value="Add To Cart" class="addtoCartBut" onclick="<?php echo isset($_COOKIE['userID']) && $_COOKIE['userID'] !== '' ? 'submitForm()' : 'redirectToLoginPage()' ?>">
                        </form>
                        <!--Selected product description-->
                        <a class="description"><?php echo $product['productDescrip']; ?></a>
                    </div> 
                </div>
            </div>
        </main>
        <br>
        <!--Footer for the product page-->
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
            //This function will redirect the user to the form if the cookie does exist
            function submitForm() {
                document.querySelector('form').submit();
            }

            //This function will redirect the user to the lspage if the cookie does not exist
            function redirectToLoginPage() {
                window.location.href = 'lspage.php';
            }
        </script>
    </body>
</html>