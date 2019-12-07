<?php
    session_start(); 
    $thisPage = "Dashboard";
    include('includes/header.php');
    include('controller/functions.php');

  if (!isLoggedIn()) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  


?>
        
    <div class="main-content">
        
        <h2>Temporary Home Page</h2>

        <div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div>
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['user'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['user']['username']; ?></strong></p>
    	<p> <a href="dashboard.php?logout='1'" style="color: red;">Logout</a> </p>
    <?php endif ?>
</div>
          
        
            
    </div>
        
</div>

<?php
	include('includes/footer.php');
?>