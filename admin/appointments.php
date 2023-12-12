<?php session_start(); ?>
<?php
	include_once("backend/db.php");

	// variable to store number of rows per page
	$limit = 10;

	$getQuery = "select * from appointments";
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
    $getQuery = "SELECT * FROM appointments order by appoint_date desc LIMIT " . $initial_page . ',' . $limit;  

    $result = mysqli_query($con, $getQuery);

?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Appointments</h2>
          <a href="calendar/calendar.php" target="_blank" class="btn btn-primary btn-sm">View on calendar</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Appointment Date</th>
              <th>Appointment Time</th>
              <th>Booked on</th>
            </tr>
          </thead>
          <tbody id="customer_list">
		  	<?php
			//display the retrieved result on the webpage
			$i=1;
			while ($row = mysqli_fetch_array($result)) {
			?>
            <tr>
              <td><?php echo $i ?></td>
              <td><?php echo $row['name'] ?></td>
              <td><?php echo $row['email'] ?></td>
              <td><?php echo $row['phone'] ?></td>
              <td><?php echo $row['appoint_date'] ?></td>
              <td>
                <?php 
                if($row['appoint_time'] < 12)
                {
                  echo $row['appoint_time'] . " AM";
                }
                else if($row['appoint_time'] == 12)
                {
                  echo $row['appoint_time'] . " PM";
                }
                else
                {
                  echo ($row['appoint_time'] - 12) . " PM";
                }
                
                ?>
              </td>
              <td><?php echo $row['submitted_on'] ?></td>
            </tr>
			<?php
			$i++;
			}
			?>
          </tbody>
		  
        </table>
		<div class="col-md-12" style="display: flex; justify-content: center; align-items: center; column-gap: 3%;">
			<?php
			// show page number with link   
			for($page_number = 1; $page_number<= $total_pages; $page_number++) {
				echo '<a href = "appointments.php?page=' . $page_number . '">' . $page_number . ' </a>';
			}
			?>
		</div>
      </div>
    </main>
  </div>
</div>




<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/customers.js"></script>