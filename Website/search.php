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
        <title>TechSavey | Search</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
    </head>

    <body>
        <!--Navigation bar for the search page-->
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
            <!--Search input for the search page-->
            <div class="container-search">
                <div class="search-wrapper">
                    <form action="search.php" method="post">
                        <!--This is to obtain the information the user wants to search on the website-->
                        <input type="text" name="search-value" placeholder="Search by product name" required>
                        <button type="submit" name="submit-search"><i class="fa fa-fw fa-search"></i> Search</button>
                    </form>
                </div>
                <?php
                    //It will then check if the submit button was clicked or pressed
                    if(isset($_POST['submit-search'])){
                        $search_value = $_POST['search-value'];
                        //It will then check the productInfo table and search for the products by product name if anything matches the users search by using the like in the sql statement
                        $stmt = $pdo->prepare("SELECT * FROM productInfo WHERE productName LIKE :search_query");
                        $stmt->execute(['search_query' => '%'.$search_value.'%']);
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                ?>
                <!--Searched products for the search page-->
                <div class="product-details">
                    <!--If the results of the search was empty the following message will be displayed for the user-->
                    <?php if (isset($_POST['submit-search']) && empty($results)): ?>
                        <p>No results found.</p>
                    <!--If the resuls of the search was not empty it will display all the products that meet the search criteria-->
                    <?php elseif (isset($_POST['submit-search'])): ?>
                        <table class="product-display">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <!--It will then loop through the table and display each row of the products that match the search criteria-->
                            <?php foreach($results as $row): ?>
                                <tr>
                                    <!--Searched product image-->
                                    <td><img src="uploaded_img/<?php echo $row['productIMG']; ?>" height="100"></td>
                                    <!--Searched product name-->
                                    <td class="product"><?php echo $row['productName']; ?></td>
                                    <!--Searched product price-->
                                    <td class="product">R<?php echo $row['productPrice']; ?></td>
                                    <!--View searched product button-->
                                    <td><a href="productpage.php?page=product&id=<?=$row['productID']?>" class="view-product">View Product</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>  
        </main>
        <br>
        <!--Footer for the search page-->
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