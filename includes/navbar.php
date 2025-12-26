<header class="main-header">
  <nav class="navbar navbar-expand-lg" style="background-color: #4CAF50;">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="#" style="padding: 10px 15px;">
        <img src="images/banner.png" alt="Logo" style="max-height: 40px; width: auto;">
      </a>

      <!-- Mobile Toggle Button -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Collapsible Navbar Content -->
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <!-- Left Navigation -->
        <ul class="navbar-nav me-auto">
          <?php
            if(isset($_SESSION['student'])){
              echo "
                <li class='nav-item'><a class='nav-link' href='index.php'>HOME</a></li>
                <li class='nav-item'><a class='nav-link' href='transaction.php'>TRANSACTION</a></li>
              ";
            } 
          ?>
        </ul>

        <!-- Right Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?php echo (!empty($voter['photo'])) ? 'images/'.$voter['photo'] : 'images/profile.jpg' ?>" class="rounded-circle me-2" alt="User Image" style="width: 30px; height: 30px; object-fit: cover;">
              <span class="d-none d-sm-inline"><?php echo $voter['firstname'].' '.$voter['lastname']; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="fa fa-user me-2"></i>Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out me-2"></i>LOGOUT</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>