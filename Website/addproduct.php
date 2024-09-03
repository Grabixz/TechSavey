<?php
    //This is to include the index page
    include 'index.php';

    //This is to create the connection to the database
    $link = mysqli_connect("localhost:3308", "root", "", "TechSavey");
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    //This is to check if the form had been submitted
    if(isset($_POST['addProduct'])){
        //This is to gather the information from the html code and store it in $ variables
        $product_name = mysqli_real_escape_string($link, $_POST['productName']);
        $product_description = mysqli_real_escape_string($link, $_POST['productDescription']);
        $product_price = mysqli_real_escape_string($link, $_POST['productPrice']);
        $product_type = mysqli_real_escape_string($link, $_POST['productType']);
        $product_image = $_FILES['productImg']['name'];
        $product_image_tmp_name = $_FILES['productImg']['tmp_name'];
        $product_image_folder = 'uploaded_img/'.$product_image;
        $userID = $_COOKIE['userID'];

        //This is to gather the files name and extension
        $file_parts = pathinfo($product_image);
        $file_name = $file_parts['filename'];
        $file_ext = $file_parts['extension'];

        //This is to check if the image doesn't already exist in the database
        $sql = "SELECT COUNT(*) AS num FROM productInfo WHERE productIMG LIKE '{$file_name}%'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['num'];

        //If the file name already exists in the database, it will increment a number to it
        if($count > 0){
            $file_name = $file_name . '_' . ($count + 1);
            $product_image = $file_name . '.' . $file_ext;
        }
        
        //This will then set the new file path. This is just incase a user has the same file name but different images.
        $product_image_folder = 'uploaded_img/'.$product_image;

        //This is to add the products information into the database
        $sql = "INSERT INTO productInfo (productName, productType, productDescrip, productPrice, productIMG, productDate, userID) 
                VALUES('$product_name', '$product_type', '$product_description', '$product_price', '$product_image', NOW(), '$userID')";
        
        //This is to execute the sql statement and to check if it was successful
        if (mysqli_query($link, $sql)){
            //This is to move the uploaded image to the correct folder and redirect back to the add product page
            move_uploaded_file($product_image_tmp_name, $product_image_folder); 
            header("Location: addproduct.php");
            exit();
        }        
    }
    //This is to delete the product they want to remove
    if(isset($_GET['delete'])){
        $productID = $_GET['delete'];
        // This is to delete the image from the uploaded_img file
        $stmt = $pdo->prepare("SELECT * FROM productInfo WHERE productID = :productID");
        $stmt->bindParam(':productID', $productID);
        $stmt->execute();
        $selected_product = $stmt->fetch(PDO::FETCH_ASSOC);
        //This will delete the selected image file
        if($selected_product) {
            $product_image_folder = 'uploaded_img/'.$selected_product['productIMG'];
            // Delete the product image file if it exists
            if(file_exists($product_image_folder)) {
                unlink($product_image_folder);
            }
            // This is to delete the product from the database
            $stmt = $pdo->prepare("DELETE FROM productInfo WHERE productID = :productID");
            $stmt->bindParam(':productID', $productID);
            $stmt->execute();
            header("Location: addproduct.php");
        }
        exit();
    }
?>
<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA_Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TechSavey | Add Product</title>

      <!--This link is for the icons-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--This link is for the css styling file-->
      <link rel="stylesheet" type="text/css" href="styling.css">
      <!--This link is for the script file-->
      <script type="text/javascript" src="script.js"></script>
   </head>

   <body>
        <!--Navigation bar for the add product page-->
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
            <!--Add product form for the add product page-->
            <div class="add-container">
                <div class="add-product">
                    <form action="addproduct.php" method="post" enctype="multipart/form-data">
                        <!--Title for Add Product Form-->
                        <span class="title">Add a new product</span>
                        <!--Product Name input-->
                        <div class="product-field">
                            <input type="text" name="productName" placeholder="Enter product name" required>
                        </div>
                        <!--Product type/category input-->
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
                        <!--Product description input-->
                        <div class="product-field">
                            <textarea name="productDescription" placeholder="Enter in the products description" rows="5" cols="50" required></textarea>
                        </div>
                        <!--Product price input-->
                        <div class="product-field">
                            <input type="number" name="productPrice" placeholder="Enter product price" required>
                        </div>
                        <!--Product image input-->
                        <div class="product-field">
                            <input type="file" name="productImg" accept="image/png, image/jpeg, image/jpg" class="product-img" required>
                        </div>
                        <!--Product add button-->
                        <div class="product-addbtn">
                            <input type="submit" name="addProduct" value="Add Product">
                        </div>
                    </form>
                </div>
                <?php
                    //This is to display all the products the user has uploaded to the site
                    $findID = $_COOKIE['userID'];
                    //This is to check if the admin logged in or not
                    if ($findID === 'AA169') {
                        $sql_select = mysqli_query($link, "SELECT * FROM productInfo");
                    } else {
                        $sql_select = mysqli_query($link, "SELECT * FROM productInfo WHERE userID = '$findID'");
                    }
                    
                ?>
                <!--Uploaded Product display for the add product page-->
                <div class="product-details">
                    <table class="product-display">
                        <thead>
                            <tr>
                                <!--This is the tables header-->
                                <th>Image</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <!--This will loop through each product in the result set-->
                        <?php while($row = mysqli_fetch_assoc($sql_select)){ ?>
                        <tr>
                            <!--Displays the products image-->
                            <td><img src="uploaded_img/<?php echo $row['productIMG']; ?>" height="100" alt=""></td>
                            <!--Displays the products name-->
                            <td class="product"><?php echo $row['productName']; ?></td>
                            <!--Displays the products type-->
                            <td class="product"><?php echo $row['productType']; ?></td>
                            <!--Displays the products description-->
                            <td class="product"><?php echo $row['productDescrip']; ?></td>
                            <!--Displays the products price-->
                            <td class="product">R<?php echo $row['productPrice']; ?></td>
                            <td>
                                <!--These are the links that will take the user to either edit the products information or delete the product they want to remove-->
                                <a href="editproduct.php?edit=<?php echo $row['productID']; ?>" class="editbtn"><i class="fa fa-fw fa-pencil"></i> Edit</a>
                                <a href="addproduct.php?delete=<?php echo $row['productID']; ?>" class="deletebtn"><i class="fa fa-fw fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </main> 
        <br>
        <!--Footer for the add product page-->
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