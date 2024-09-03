<?php
    //This is to include the index page
    include 'index.php';

    //This is to check if the a product was submitted through POST and that it is a valid numeric ID
    if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
        //This then sets the $product_id to an integer
        $product_id = (int)$_POST['product_id'];
        $stmt = $pdo->prepare('SELECT * FROM productInfo WHERE productID = ?');
        //This then query the database for the product with the submitted ID
        $stmt->execute([$_POST['product_id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        //This checks if the product was found in the database
        if ($product) {
            //This then checks if the cart session variable exists and is an array
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                //Then if the product allready exists in the cart, it will then increment the quantity by one
                if (array_key_exists($product_id, $_SESSION['cart'])) {
                    //If the product exists in cart so just update the quanity
                    $_SESSION['cart'][$product_id] += 1;
                } else {
                    //If the product is not in cart so add it
                    $_SESSION['cart'][$product_id] = 1;
                }
            } else {
                //Else if the cart session variable doesn't exist, it will create it with the current product and a quantity of one
                $_SESSION['cart'] = array($product_id => 1);
            }
        }
        //This will prevent the form from resubmission by redirecting to the cart page.
        header('location: cartpage.php');
        exit;
    }

    //This is to check if the remove request was submitted through the GET and check if it is a valid numeric ID and that the product exists in the cart
    if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
        //It will then remove the product from the cart by unsetting its ID from the cart session variable
        unset($_SESSION['cart'][$_GET['remove']]);
    }

    //This is to check if a place order request was submitted through POST and check if the cart session varible exists and if it is not empty
    if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        //It will then gather the products in the cart from the cart session variable
        $cart_products = $_SESSION['cart'];
        //It will gather the products IDs in the cart
        $product_ids = array_keys($cart_products);
        //It will then query the database for the products with the IDs in the cart
        $stmt = $pdo->prepare('SELECT * FROM productInfo WHERE productID IN ('.implode(',',$product_ids).')');
        $stmt->execute();
        $selected_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //This will then gather the current date and time and the cookies value
        $order_date = date('Y-m-d H:i:s');
        $userID = $_COOKIE['userID'];

        //It will then loop through each selected product in the cart
        foreach ($selected_products as $product) {
            //It will then add the information into the receiptsinfo table in the database
            $stmt = $pdo->prepare('INSERT INTO receiptsInfo (receiptName, receiptType, receiptDescrip, receiptPrice, receiptDate, userID) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$product['productName'], $product['productType'], $product['productDescrip'], $product['productPrice'], $order_date, $userID]);
        }
    
        //This will then loop through each selected product in the cart
        foreach ($selected_products as $product) {
            //It will then remove every products image from the uploaded_img file
            $product_image_folder = 'uploaded_img/'.$product['productIMG'];
            unlink($product_image_folder);
        }
    
        //This will then delete the information from the productsInfo table that was in the cart and take the user back to the cartpage
        $stmt = $pdo->prepare('DELETE FROM productInfo WHERE productID IN ('.implode(',',$product_ids).')');
        $stmt->execute();
        header("Location: cartpage.php");
        exit();
    }        

    //This is to check if there are any products in the users shopping cart by checking the cart session variable
    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $products = array();
    $subtotal = 0.00;
    //This is to check if there are any products in the cart
    if ($products_in_cart) {
        //Then it will convert the array of productIDs in the cart to a string of question marks to use in the sql query
        $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
        $stmt = $pdo->prepare('SELECT * FROM productInfo WHERE productID IN (' . $array_to_question_marks . ')');
        //It will then execute the prepared statement with the array of product IDs as the parameter values
        $stmt->execute(array_keys($products_in_cart));
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //This will then calculate the subtotal by iterating through the $products array and multiplying each product's price by the quantity of that product in the cart
        foreach ($products as $product) {
            $subtotal += (float)$product['productPrice'] * (int)$products_in_cart[$product['productID']];
        }
    }
?>
<!doctype html>
<html>
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA_Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TechSavey | Cart</title>

        <!--This link is for the icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--This link is for the css styling file-->
        <link rel="stylesheet" type="text/css" href="styling.css">
        <!--This link is for the script file-->
        <script type="text/javascript" src="script.js"></script>
    </head>

    <body>
        <!--Navigation bar for the cart page-->
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
            <!--Shopping cart products for the cart page -->
            <div class="cart-title">
                <label name="Title">Shopping Page</label>
            </div>
                <div class="cart-details">
                <form action="cartpage.php" method="post">
                    <!--This is to check if there are any products in the cart if there isnt, it will display the message below-->
                    <?php if (empty($products)): ?>
                        <p>You have no products in your cart</p>
                    <?php else: ?>
                    <!--If there are products in the cart the following will be displayed in the table-->
                    <table class="cart-display">
                        <thead>
                            <tr>
                                <th colspan="2">Product</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                            <!--It will then loop through the $products array and output a table row for each product in the cart-->
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <!--Product Image-->
                                    <td><a href="productpage.php?page=product&id=<?=$product['productID']?>"><img src="uploaded_img/<?=$product['productIMG']?>" width="50" height="50"></a></td>
                                    <!--Product Name-->
                                    <td class="carts"><a href="productpage.php?page=product&id=<?=$product['productID']?>"><?=$product['productName']?></a></td>
                                    <!--Product Price-->
                                    <td class="carts">R<?=$product['productPrice']?></td>
                                    <!--Remove button-->
                                    <td><a href="cartpage.php?page=cart&remove=<?=$product['productID']?>" class="remove">Remove</a></td>
                                </tr>
                            <?php endforeach; ?>
                    </table>
                    <!--This then displays the subtotal of the amount of all the amounts of all products in the cart-->
                    <div class="subtotal">
                        <span class="text">Subtotal:</span>
                        <span class="price"> R<?=$subtotal?></span>
                    </div>
                    <div class="buttons">
                        <input type="submit" value="Place Order" name="placeorder" class="placeorder">
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </main>
        <br>
        <!--Footer for the cart page page-->
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