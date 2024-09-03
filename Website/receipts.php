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
        <title>TechSavey | Receipts</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the javascript file-->
        <script type="text/javascript" src="script.js"></script>
   </head>

    <body>
        <!--Navigation bar for the receipts page-->
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
            <div class="title">
                <label name="Title">Your product receipts</label>
            </div>
            <?php
                //This is to gather the cookies value
                $userID = $_COOKIE['userID'];
                //This is to find all the users receipts
                $stmt = $pdo->prepare("SELECT * FROM receiptsInfo WHERE userID = ?");
                $stmt->execute([$userID]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <!--All Receipts for the receipts page-->
            <div class="receipt-details">
                <!--This is to check whether there are any receipts for the user. IF not it will display the following message below-->
                <?php if (count($result) == 0) { ?>
                    <p>You have not purchased any products yet</p>
                <?php } else { ?>
                    <!--If there receipts in the table the following will be displayed-->
                    <table class="receipt-display">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <!--This will loop through each row and display each row in the table for the receipts for the user-->
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <!--Purchased product name-->
                                <td class="receipts"><?php echo $row['receiptName']; ?></td>
                                <!--Purchased product type/category-->
                                <td class="receipts"><?php echo $row['receiptType']; ?></td>
                                <!--Purchased product description-->
                                <td class="receipts"><?php echo $row['receiptDescrip']; ?></td>
                                <!--Purchased product price-->
                                <td class="receipts">R<?php echo $row['receiptPrice']; ?></td>
                                <!--Purchased product date-->
                                <td class="receipts"><?php echo $row['receiptDate']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>
        </main> 
        <!--Footer for the receipts page-->
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