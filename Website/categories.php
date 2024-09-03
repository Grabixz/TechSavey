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
        <title>TechSavey | Categories</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
    </head>

    <body>
        <!--Navigation bar for the categories page-->
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
            <!--This is to display the name of category that was selected-->
            <div class="title">
                <label name="Title" id="button-label">Button Label</label>
            </div>
            <script>
                //This is to listen for the DOMContentLoaded event
                document.addEventListener('DOMContentLoaded', function() {
                    //It will then retrieve the value from the local storage with the key 'buttonValue'
                    var buttonValue = localStorage.getItem('buttonValue');
                    //If the retrieved value exists, it will then set the innerHTML of an element with the ID 'button-label' to the retrieved value
                    if (buttonValue) {
                        var label = document.getElementById('button-label');
                        label.innerHTML = buttonValue;
                    }
                });
            </script>

            <?php
                //This is to retrieve the buttons value from the URL and decode it
                $buttonValue = urldecode($_GET['buttonValue']);
                //It will then display all the information in the table that contains the required information
                $stmt = $pdo->prepare("SELECT * FROM productInfo WHERE productType = ?");
                $stmt->execute([$buttonValue]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            ?>
            
            <!--All Products information for the categories page-->
            <div class="product-details">
                <!--This is to display a message if there are no products for the specific category-->
                <?php if (empty($result)) { ?>
                    <p>No products found for this category.</p>
                <?php } else { ?>
                    <table class="product-display">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <?php 
                            //This will then display all the products for the specific category that was selected
                            $stmt = $pdo->prepare("SELECT * FROM productInfo WHERE productType = :buttonValue");
                            $stmt->execute(['buttonValue' => $_GET['buttonValue']]);
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                        ?>
                        <tr>
                            <!--Products Image-->
                            <td><img src="uploaded_img/<?php echo $row['productIMG']; ?>" height="100"></td>
                            <!--Products Name-->
                            <td class="product"><?php echo $row['productName']; ?></td>
                            <!--Products Price-->
                            <td class="product">R<?php echo $row['productPrice']; ?></td>
                            <!--View Product Button-->
                            <td><a href="productpage.php?page=product&id=<?=$row['productID']?>" class="view-product">View Product</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>
        </main> 
        <!--Footer for the categories page-->
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