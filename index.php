<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location: admin/home.php');
  	}

    if(isset($_SESSION['voter'])){
      header('location: home.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>BCAS Voting System</title>
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	
  	<!-- Bootstrap 5 -->
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  	<!-- Font Awesome 6 -->
  	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  	<!-- Google Fonts -->
  	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  	<style>
    :root {
      --primary-color: #198754;
      --secondary-color: #6c757d;
      --success-color: #20c997;
      --danger-color: #dc3545;
      --warning-color: #ffc107;
      --info-color: #0dcaf0;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --gradient-primary: linear-gradient(135deg, #52b788 0%, #2d6a4f 100%);
      --gradient-secondary: linear-gradient(135deg, #40916c 0%, #1b4332 100%);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--gradient-primary);
      min-height: 100vh;
      overflow-x: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .main-container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .login-wrapper {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(10px);
      overflow: hidden;
      width: 100%;
      min-height: 700px;
      margin: 0 auto;
    }

    .parties-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 2rem;
      height: 100%;
      position: relative;
    }

    .section-title {
      color: var(--dark-color);
      font-weight: 600;
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      text-align: center;
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: var(--primary-color);
      border-radius: 2px;
    }

    .carousel-item {
      padding: 1rem 0;
    }

    .party-name {
      background: var(--primary-color);
      color: white;
      padding: 1rem;
      border-radius: 10px;
      text-align: center;
      font-weight: 600;
      font-size: 1.2rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }

    .candidates-table {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .candidates-table .table {
      margin-bottom: 0;
    }

    .candidates-table .table thead th {
      background: #f8f9fa;
      color: var(--dark-color);
      border: none;
      border-bottom: 2px solid #dee2e6;
      padding: 1rem 0.75rem;
      font-weight: 600;
    }

    .candidates-table .table tbody td {
      padding: 1rem 0.75rem;
      vertical-align: middle;
      border-color: #f8f9fa;
    }

    .candidate-photo {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--primary-color);
    }

    .position-badge {
      background: transparent;
      color: var(--primary-color);
      padding: 0.25rem 0.75rem;
      /* border: 2px solid var(--primary-color); */
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .login-section {
      padding: 3rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: white;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 2rem;
    }

    .logo-container img {
      max-width: 150px;
      height: auto;
      margin-bottom: 1rem;
    }

    .system-title {
      color: var(--dark-color);
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .system-subtitle {
      color: var(--secondary-color);
      font-size: 1rem;
      margin-bottom: 2rem;
    }

    .form-floating {
      margin-bottom: 1.5rem;
    }

    .form-floating .form-control {
      border: 2px solid #e9ecef;
      border-radius: 12px;
      padding: 1rem 0.75rem;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-floating .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
    }

    .form-floating label {
      color: var(--secondary-color);
      font-weight: 500;
    }

    .login-btn {
      background: var(--gradient-primary);
      border: none;
      border-radius: 12px;
      padding: 0.875rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }

    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(25, 135, 84, 0.4);
      background: var(--gradient-primary);
    }

    .alert-custom {
      border: none;
      border-radius: 12px;
      padding: 1rem 1.5rem;
      margin-top: 1rem;
      background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
      color: var(--danger-color);
      border-left: 4px solid var(--danger-color);
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 40px;
      height: 40px;
      background: var(--primary-color);
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
      opacity: 0.8;
      transition: all 0.3s ease;
    }

    .carousel-control-prev {
      left: -20px;
    }

    .carousel-control-next {
      right: -20px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
      opacity: 1;
      transform: translateY(-50%) scale(1.1);
    }

    .carousel-indicators {
      bottom: -40px;
    }

    .carousel-indicators button {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: var(--primary-color);
      opacity: 0.5;
      transition: all 0.3s ease;
    }

    .carousel-indicators button.active {
      opacity: 1;
      transform: scale(1.2);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .main-container {
        padding: 10px;
      }
      
      .login-wrapper {
        border-radius: 15px;
        min-height: auto;
      }
      
      .parties-section {
        display: none; /* Hide parties section on mobile */
      }
      
      .login-section {
        padding: 2rem 1.5rem;
        order: 1;
      }
      
      .section-title {
        font-size: 1.3rem;
      }
      
      .party-name {
        font-size: 1.1rem;
        padding: 0.75rem;
      }
      
      .candidates-table .table thead th,
      .candidates-table .table tbody td {
        padding: 0.75rem 0.5rem;
        font-size: 0.9rem;
      }
      
      .candidate-photo {
        width: 40px;
        height: 40px;
      }
      
      .position-badge {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
      }
      
      .carousel-control-prev,
      .carousel-control-next {
        width: 35px;
        height: 35px;
      }
      
      .carousel-control-prev {
        left: -15px;
      }
      
      .carousel-control-next {
        right: -15px;
      }
    }

    @media (max-width: 576px) {
      .system-title {
        font-size: 1.3rem;
      }
      
      .login-btn {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
      }
      
      .candidates-table .table {
        font-size: 0.85rem;
      }
      
      .position-badge {
        display: block;
        margin-top: 0.25rem;
      }
    }

    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-wrapper {
      animation: fadeInUp 0.6s ease-out;
    }

    .candidate-row:hover {
      background-color: #f8f9fa;
      transition: background-color 0.3s ease;
    }
  	</style>
</head>

<body>
<?php
  $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
  $title = $parse['election_title'];
?>

<div class="main-container">
    <div class="login-wrapper">
      <div class="row g-0 h-100">
        
        <!-- Parties and Candidates Section -->
        <div class="col-lg-7 col-md-6">
          <div class="parties-section h-100">
            <h2 class="section-title"><?php echo strtoupper($title); ?></h2>
            
            <div id="partiesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
              <div class="carousel-inner">
                <?php
                include 'includes/conn.php';

                $sql = "SELECT * FROM party";
                $query = $conn->query($sql);

                $index = 0;
                $indicators = '';
                
                while ($row = $query->fetch_assoc()) {
                    $active = $index == 0 ? 'active' : '';
                    $indicators .= '<button type="button" data-bs-target="#partiesCarousel" data-bs-slide-to="'.$index.'" class="'.$active.'" aria-label="Party '.($index + 1).'"></button>';
                    
                    echo '<div class="carousel-item '.$active.'">';
                    echo '<div class="party-name">' . htmlspecialchars($row['partylist']) . '</div>';
                    echo '<div class="candidates-table">';
                    echo '<table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th style="width: 30%">Candidate</th>
                                <th style="width: 25%">Position</th>
                                <th style="width: 45%">Full Name</th>
                              </tr>
                            </thead>
                            <tbody>';

                    // Fetch candidates belonging to this party
                    $sql_candidates = "SELECT c.*, p.description AS position FROM candidates c LEFT JOIN positions p ON c.position_id=p.id WHERE partylist_id=" . $row['id'] . " ORDER BY p.priority ASC";
                    $cquery = $conn->query($sql_candidates);

                    while ($crow = $cquery->fetch_assoc()) {
                        $photo = $crow['photo'] != '' ? 'images/' . htmlspecialchars($crow['photo']) : 'images/profile.jpg';
                        $fullname = htmlspecialchars($crow['firstname'] . ' ' . $crow['lastname']);
                        $position = htmlspecialchars($crow['position']);

                        echo '<tr class="candidate-row">
                                <td>
                                  <img src="' . $photo . '" alt="' . $fullname . '" class="candidate-photo" title="' . $position . '">
                                </td>
                                <td>
                                  <span class="position-badge">' . $position . '</span>
                                </td>
                                <td>
                                  <strong>' . $fullname . '</strong>
                                </td>
                              </tr>';
                    }

                    echo '</tbody></table>';
                    echo '</div>'; // Close candidates-table
                    echo '</div>'; // Close carousel-item

                    $index++;
                }
                ?>
              </div>

              <!-- Indicators -->
              <?php if ($index > 1): ?>
              <div class="carousel-indicators">
                <?php echo $indicators; ?>
              </div>
              <?php endif; ?>

              <!-- Controls -->
              <?php if ($index > 1): ?>
              <button class="carousel-control-prev" type="button" data-bs-target="#partiesCarousel" data-bs-slide="prev">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#partiesCarousel" data-bs-slide="next">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                <span class="visually-hidden">Next</span>
              </button>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Login Section -->
        <div class="col-lg-5 col-md-6">
          <div class="login-section">
            <div class="login-card">
              <div class="logo-container">
                <img src="images/logo.png" alt="BCAS Logo" class="img-fluid">
                <h1 class="system-title">BCAS Voting System</h1>
                <p class="system-subtitle">Cast your vote securely</p>
              </div>

              <form action="login.php" method="POST" class="needs-validation" novalidate>
                <div class="form-floating">
                  <input type="text" 
                         class="form-control" 
                         id="voter" 
                         name="voter" 
                         placeholder="Student No." 
                         required>
                  <label for="voter"><i class="fas fa-user me-2"></i>Student Number</label>
                </div>

                <div class="form-floating">
                  <input type="password" 
                         class="form-control" 
                         id="password" 
                         name="password" 
                         placeholder="Last Name" 
                         required>
                  <label for="password"><i class="fas fa-lock me-2"></i>Last Name</label>
                </div>

                <button type="submit" name="login" class="login-btn">
                  <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
              </form>

              <?php
              if(isset($_SESSION['error'])){
                echo '<div class="alert alert-custom" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        '.$_SESSION['error'].'
                      </div>';
                unset($_SESSION['error']);
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Form validation
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
  const alerts = document.querySelectorAll('.alert-custom');
  alerts.forEach(function(alert) {
    setTimeout(function() {
      alert.style.opacity = '0';
      setTimeout(function() {
        alert.remove();
      }, 300);
    }, 5000);
  });
});

// Smooth carousel transitions
document.addEventListener('DOMContentLoaded', function() {
  const carousel = document.querySelector('#partiesCarousel');
  if (carousel) {
    carousel.addEventListener('slide.bs.carousel', function () {
      // Add any custom slide animations here if needed
    });
  }
});
</script>

</body>
</html>