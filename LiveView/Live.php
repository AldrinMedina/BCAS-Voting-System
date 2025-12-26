<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<style>
    /* Sticky Footer Styles */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1;
    }

    footer {
        background-color: #4CAF50;
        color: white;
        padding: 20px 0;
        text-align: center;
        margin-top: auto;
    }

    footer a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
    }

    footer a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container">
        <h2 class="text-center">Live Voting Leaderboard</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Candidate</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody id="leaderboard">
                    <!-- Dynamic content will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="main-footer"  style=" /*background-color: #4CAF50; color: white;*/ padding: 20px 0;">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>All rights reserved</b>
      </div>
      <strong>Copyright &copy; 2024 <a href="https://bcas.edu.ph">Batangas College of Arts and Sciences INC.</a></strong>
    </div>
    <!-- /.container -->
</footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadLeaderboard() {
            $.ajax({
                url: 'leaderboard.php',
                method: 'GET',
                success: function(data) {
                    $('#leaderboard').html(data);
                }
            });
        }

        // Load leaderboard on page load
        $(document).ready(function() {
            loadLeaderboard();

            // Refresh leaderboard every 5 seconds
            setInterval(loadLeaderboard, 5000);
        });
    </script>
</body>
</html>
