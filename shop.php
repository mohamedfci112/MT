<?php
require_once('header.php');
include_once("admin/backend/db.php");

// variable to store number of rows per page
$limit = 9;
//
if(isset ($_GET['filter_price']))
{
    $priceType = $_GET['filter_price'];
    if($priceType == "low"){ $getQuery = "select * from shop order by CAST(item_price AS UNSIGNED) asc"; }
    if($priceType == "high"){ $getQuery = "select * from shop order by CAST(item_price AS UNSIGNED) desc"; }
    
    $result = mysqli_query($con, $getQuery);
    $total_rows = mysqli_num_rows($result);
    // get the required number of pages
    $total_pages = ceil ($total_rows / $limit);

    // update the active page number
    if (!isset ($_GET['page']) ) {  

    $page_number = 1;

    } else {  

    $page_number = $_GET['page'];  

    }

    // get the initial page number
    $initial_page = ($page_number-1) * $limit;



    // get data of selected rows per page
    if($priceType == "low"){ $getQuery = "SELECT *FROM shop order by CAST(item_price AS UNSIGNED) asc LIMIT " . $initial_page . ',' . $limit; }
    if($priceType == "high"){ $getQuery = "SELECT *FROM shop order by CAST(item_price AS UNSIGNED) desc LIMIT " . $initial_page . ',' . $limit; }

    $result = mysqli_query($con, $getQuery);

}

//
if(isset ($_GET['filter_category']))
{
    $categoryid = $_GET['filter_category'];
    $getQuery = "select * from shop where category_id='$categoryid'";
    $result = mysqli_query($con, $getQuery);
    $total_rows = mysqli_num_rows($result);
    // get the required number of pages
    $total_pages = ceil ($total_rows / $limit);

    // update the active page number
    if (!isset ($_GET['page']) ) {  

    $page_number = 1;

    } else {  

    $page_number = $_GET['page'];  

    }

    // get the initial page number
    $initial_page = ($page_number-1) * $limit;



    // get data of selected rows per page    
    $getQuery = "SELECT *FROM shop where category_id='$categoryid' LIMIT " . $initial_page . ',' . $limit;  

    $result = mysqli_query($con, $getQuery);

}
//
if(isset ($_GET['filter_collection']))
{
    $collectionid = $_GET['filter_collection'];
    $getQuery = "select * from shop where collection_id='$collectionid'";
    $result = mysqli_query($con, $getQuery);
    $total_rows = mysqli_num_rows($result);
    // get the required number of pages
    $total_pages = ceil ($total_rows / $limit);

    // update the active page number
    if (!isset ($_GET['page']) ) {  

    $page_number = 1;

    } else {  

    $page_number = $_GET['page'];  

    }

    // get the initial page number
    $initial_page = ($page_number-1) * $limit;



    // get data of selected rows per page    
    $getQuery = "SELECT *FROM shop where collection_id='$collectionid' LIMIT " . $initial_page . ',' . $limit;  

    $result = mysqli_query($con, $getQuery);

}

if(!isset ($_GET['filter_category']) && !isset ($_GET['filter_collection']) && !isset ($_GET['filter_price']))
{
    $getQuery = "select * from shop";
    $result = mysqli_query($con, $getQuery);
    $total_rows = mysqli_num_rows($result);

    // get the required number of pages
    $total_pages = ceil ($total_rows / $limit);

    // update the active page number
    if (!isset ($_GET['page']) ) {  

        $page_number = 1;

    } else {  

        $page_number = $_GET['page'];  

    }

    // get the initial page number
    $initial_page = ($page_number-1) * $limit;



    // get data of selected rows per page    
    $getQuery = "SELECT *FROM shop LIMIT " . $initial_page . ',' . $limit;  

    $result = mysqli_query($con, $getQuery);
}

//

//get category counts
$getCategory = "SELECT c.cat_id,c.cat_title, count(s.category_id) as catCount from shop s, categories c where s.category_id=c.cat_id group by s.category_id";  

$catresult = mysqli_query($con, $getCategory);

//get collection counts
$getCollection = "SELECT c.brand_id,c.brand_title, count(s.collection_id) as colCount from shop s, brands c where s.collection_id=c.brand_id group by s.collection_id";  

$colresult = mysqli_query($con, $getCollection);

?>

<link rel="stylesheet" href="./assets/css/shop.css">

<div class="container-fluid my-5">


    <div class="row">


        <div class="col-md-3">
            <div class="sidebar">

                <div class="sidebar-categories area">
                    <a href="shop.php" class="sidebar-title">All Products</a>
                    <hr>
                </div>

                <div class="sidebar-categories area">
                    <a href="#sidebar-categories" class="sidebar-title" data-bs-toggle="collapse">Categories</a>
                    <hr>

                    <div id="sidebar-categories" class="collapse show">
                        <ul class="sidebar-list">
                        <?php
                        //display the retrieved result on the webpage
                        while ($row = mysqli_fetch_array($catresult)) {
                        ?>
                            <li><a href="shop.php?filter_category=<?php echo $row['cat_id'] ?>"><?php echo $row['cat_title'] ?> <span>(<?php echo $row['catCount'] ?>)</span></a></li>
                        <?php
                        }
                        ?>
                        </ul>
                    </div>
                </div>

                <div class="sidebar-categories area">
                    <a href="#sidebar-categories" class="sidebar-title" data-bs-toggle="collapse">Collections</a>
                    <hr>

                    <div id="sidebar-categories" class="collapse show">
                        <ul class="sidebar-list">
                        <?php
                        //display the retrieved result on the webpage
                        while ($row = mysqli_fetch_array($colresult)) {
                        ?>
                            <li><a href="shop.php?filter_collection=<?php echo $row['brand_id'] ?>"><?php echo $row['brand_title'] ?> <span>(<?php echo $row['colCount'] ?>)</span></a></li>
                        <?php
                        }
                        ?>
                        </ul>
                    </div>
                </div>


                <div class="sidebar-sort area">
                    <a href="#sidebar-sort" class="sidebar-title" data-bs-toggle="collapse">Sort By</a>
                    <hr>



                    <div id="sidebar-sort" class="collapse show">
                        <ul class="sidebar-list">

                            <li><a href="shop.php?filter_price=low">Price: Lowest to Highest</a></li>
                            <li><a href="shop.php?filter_price=high">Price: Highest to Lowest</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-9">

            <div class="content_page">

                <!--cards-->
                <?php
                //display the retrieved result on the webpage
                while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="card">
                    
                    <div class="content">
                        
                        <h3><a href="product_details.php?id=<?php echo $row['id'] ?>" style="color:#93784d;-webkit-text-fill-color: white;-webkit-text-stroke-width: 2px;-webkit-text-stroke-color: #93784d;"><?php echo $row['item_name'] ?></a></h3>
                        <span style="color:white;"><b>Price: </b><span><?php echo $row['item_price'] ?> EGP</span></span>
                    </div>
                    <div class="image">
                        <img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt="Image 1">
                    </div>
                    <div class="overlay">
                        
                        <img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt="Image 2">
                    </div>
                </div>
                <?php
                }
                ?>
                <!--cards-->

            </div>

            <div class="col-md-12" style="display: flex;
            justify-content: center;
            align-items: center;
            column-gap: 3%;">
                <?php
                // show page number with link   
                for($page_number = 1; $page_number<= $total_pages; $page_number++) {
                    if(isset ($_GET['filter_price']))
                    {
                        $price=$_GET['filter_price'];
                        echo '<a href = "shop.php?page=' . $page_number . '&filter_price=' . $price . '">' . $page_number . ' </a>'; 
                    } 

                    //
                    if(isset ($_GET['filter_category']))
                    {
                        $category=$_GET['filter_category'];
                        echo '<a href = "shop.php?page=' . $page_number . '&filter_category=' . $category . '">' . $page_number . ' </a>'; 
                    }
                    //
                    if(isset ($_GET['filter_collection']))
                    {
                        $collection=$_GET['filter_collection'];
                        echo '<a href = "shop.php?page=' . $page_number . '&filter_collection=' . $collection . '">' . $page_number . ' </a>'; 
                    }

                    if(!isset ($_GET['filter_category']) && !isset ($_GET['filter_collection']) && !isset ($_GET['filter_price']))
                    {
                    echo '<a href = "shop.php?page=' . $page_number . '">' . $page_number . ' </a>';  
                    }


                }
                ?>
            </div>

        </div>


    </div>


</div>




<?php
require_once('footer.php');
?>