<?php
    //This is to create the connection to the database
    $link = mysqli_connect("localhost:3308", "root", "", "TechSavey");
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    //This is to gather the productID from the addproduct page when the user selected the edit button
    $productID = $_GET['edit'];

    //This is to check if the updateButton was clicked/pressed
    if(isset($_POST['updateProduct'])){
        //This is to get the updated product details from the form
        $product_name = mysqli_real_escape_string($link, $_POST['productName']);
        $product_description = mysqli_real_escape_string($link, $_POST['productDescription']);
        $product_price = mysqli_real_escape_string($link, $_POST['productPrice']);
        $product_type = mysqli_real_escape_string($link, $_POST['productType']);
        $product_image = $_FILES['productImg']['name'];
        $product_image_tmp_name = $_FILES['productImg']['tmp_name'];
        $product_image_folder = 'uploaded_img/'.$product_image;
        $userID = $_COOKIE['userID'];

        //This is to update the products details in the database
        $sql = "UPDATE productInfo SET productName='$product_name', productType='$product_type', productDescrip='$product_description', productPrice='$product_price', productIMG='$product_image' WHERE productId = '$productID'";

        //This is if the query was successful
        if (mysqli_query($link, $sql)){
            move_uploaded_file($product_image_tmp_name, $product_image_folder); 
            header("Location: addproduct.php");
            echo '<script>alert("Product added Successfully!");</script>';
            exit();
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA_Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TechSavey | Edit Product</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
    </head>

   <body>
        <!--Navigation bar for the edit product page-->
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
            <!--Edit product form for the edit product page-->
            <div class="add-container">
                <div class="add-product">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <!--Title for the edit/update product-->
                        <span class="title">Update Product Info</span>
                        <!--Updated product name input-->
                        <div class="product-field">
                            <input type="text" name="productName" placeholder="Enter product name" required>
                        </div>
                        <!--Updated product type/category input-->
                        <div class="product-field">
                            <select name="productType" required>
                                <option value="" disabled selected hidden>Choose a product type</option>
                                <option value="Cameras">Cameras</option>
                                <option value="Cell Phones">Cell Phones</option>
                                <option value="Computers">Computers</option>
                                <option value="TVs & Audio">TV's & Audio</option>
                                <option value="Video Games">Video Games</option>
                            </select>
                        </div>
                        <!--Updated product description input-->
                        <div class="product-field">
                            <textarea name="productDescription" placeholder="Enter in the products description" rows="5" cols="50" required></textarea>
                        </div>
                        <!--Updated product price input-->
                        <div class="product-field">
                            <input type="number" name="productPrice" placeholder="Enter product price" required>
                        </div>
                        <!--Updated product image input-->
                        <div class="product-field">
                            <input type="file" name="productImg" accept="image/png, image/jpeg, image/jpg" class="product-img" required>
                        </div>
                        <!--Update product button-->   
                        <div class="product-updatebtn">
                            <input type="submit" class="updatebtn" name="updateProduct" value="Update Product">
                        </div>
                        <!--Go back button-->  
                        <div class="product-back">
                            <a href="addproduct.php" class="backbtn">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </main> 
        <br>
        <!--Footer for the edit product page-->
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