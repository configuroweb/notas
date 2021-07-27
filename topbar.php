<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li>
        <a class="nav-link text-white"  href="./" role="button"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <?php if(isset($_SESSION['rs_id'])): ?>
        <li class="nav-item">
        <a class="nav-link" href="ajax.php?action=logout" >
          <i class="fas fa-user"></i>
          <?php echo ucwords($_SESSION['rs_name']) ?>
          <i class="fa fa-sign-out-alt"></i>
        </a>
      </li>
      <?php endif;  ?>
    </ul>
  </nav>
  <!-- /.navbar -->
