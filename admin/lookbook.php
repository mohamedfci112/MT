<?php session_start(); ?>
<?php
include_once("backend/db.php");

$records = mysqli_query($con,"select s.*, b.brand_title from lookbook s, brands b where s.collection_id=b.brand_id");

if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM `users` where `id`='$id'";
    mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);			
    echo '<script type="text/javascript"> alert("Deleted Successfully!"); window.location.href="users.php";</script>';  // alert message
}
?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Lookbook List</h2>
      	</div>
      	<div class="col-2">
      		<a href="add_lookbook.php" class="btn btn-warning btn-sm">Add Item</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Name</th>
              <th>Price</th>
              <th>Collection</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="product_list">
              <?php
              $i=0;
                while($data = mysqli_fetch_array($records))
                {
                  $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><img width="60" height="60" src="../lookbookImages/<?php echo $data['id'] ?>/<?php echo $data['image1'] ?>"></td>
                  <td><?php echo $data['item_name'] ?></td>
                  <td><?php echo $data['item_price'] ?></td>
                  <td><?php echo $data['brand_title'] ?></td>
                  <td>
                    <a class="btn btn-sm btn-warning" href="edit_lookbook.php?id=<?php echo $data['id'] ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" onClick="javascript: return confirm('Please confirm deletion');" href="backend/delete_lookbook.php?id=<?php echo $data['id'] ?>">Delete</a>
                  </td>
                </tr>
                <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>



<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/products.js"></script>