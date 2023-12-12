<?php
require_once('header.php');
include_once("admin/backend/db.php");

// variable to store number of rows per page
$limit = 9;

$getQuery = "select * from lookbook";
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
$getQuery = "SELECT *FROM lookbook LIMIT " . $initial_page . ',' . $limit;  

$result = mysqli_query($con, $getQuery);


?>
<link rel="stylesheet" href="./assets/css/lookbook.css">



<div class="container">

    <section class="section-4">
    <?php
    //display the retrieved result on the webpage
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <figure class="col-md-4 col-sm-12 figure">
            <img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt="">
            <div>
                <h3>See <span>More</span></h3>
                <a href="lookbook_details.php?id=<?php echo $row['id'] ?>"></a>
            </div>
        </figure>
    <?php
    }
    ?>
    </section>
    <div class="col-md-12" style="display: flex;
    justify-content: center;
    align-items: center;
    column-gap: 3%;">
    <?php
    // show page number with link   
    for($page_number = 1; $page_number<= $total_pages; $page_number++) {  

        echo '<a href = "lookbook.php?page=' . $page_number . '">' . $page_number . ' </a>';  

    }
    ?>
    </div>

</div>



<?php
require_once('footer.php');
?>