<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
  <style>
    .candidates_table{
      overflow-x: scroll;

      ::-webkit-scrollbar{
        width: 0px ;
        height: 0px;
      }
      ::-webkit-scrollbar-track {
        width: 0px ;
        height: 0px;
      }

      ::-webkit-scrollbar-thumb {
          width: 0px ;
          height: 0px;
      }

      ::-webkit-scrollbar-thumb:hover {
        width: 0px ;
        height: 0px;
      }
    }
  </style>
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Candidates List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Candidates</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="add_cand"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <ul class="nav nav-tabs">
                <?php
                  $sql = "SELECT * FROM party";
                  $query = $conn -> query($sql);
                  $party='';
                  $index = 0;
                  while($row = $query->fetch_assoc()){
                    $party .= '<li class="party_li ' . ($index == 0 ? 'active' : '') . '"><a href="#" class="partylist" data-id="'.$row['id'].'">'.$row['partylist'].'</a></li>';
                    $index++;
                  }
                  
                  echo $party;
                ?>
              </ul>
              <br>
              <?php
                $sql = "SELECT * FROM party";
                $query = $conn -> query($sql);
                $party='';
                $index = 0;
                while($row = $query->fetch_assoc()){
                  $party.='
                  <div id = "party-'.$row['id'].'" class = "candidates_table '.($index == 0 ? '':'hidden').'">
                    <table id="party'.$row['id'].'" class="table table-bordered">
                      <thead>
                        <th class="hidden"></th>
                        <th>Position</th>
                        <th>Photo</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Party List</th>
                        <th>Tools</th>
                      </thead>
                      <tbody>
                      ';
                        $sql = "SELECT *, candidates.id AS canid FROM candidates LEFT JOIN positions ON positions.id=candidates.position_id LEFT JOIN party ON party.id=candidates.partylist_id WHERE candidates.partylist_id = '".$row['id']."' ORDER BY positions.priority ASC";
                          $cquery = $conn->query($sql);
                          while($crow = $cquery->fetch_assoc()){
                            $image = (!empty($crow['photo'])) ? '../images/'.$crow['photo'] : '../images/profile.jpg';
                            $party.="
                              <tr>
                                <td class='hidden'></td>
                                <td>".$crow['description']."</td>
                                <td>
                                  <img src='".$image."' width='30px' height='30px'>
                                  <a href='#edit_photo' data-toggle='modal' class='pull-right photo' data-id='".$crow['canid']."'><span class='fa fa-edit'></span></a>
                                </td>
                                <td>".$crow['firstname']."</td>
                                <td>".$crow['lastname']."</td>
                                <td>".$crow['partylist']."</td>
                                <td>
                                  <button class='btn btn-success btn-sm edit btn-flat' data-id='".$crow['canid']."'><i class='fa fa-edit'></i> Edit</button>
                                  <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$crow['canid']."'><i class='fa fa-trash'></i> Delete</button>
                                </td>
                              </tr>
                            ";
                          }
                      $party.='
                      </tbody>
                    </table>
                  </div>
                  ';
                  $index++;
                }
                echo $party;

              ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/candidates_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
  $(function () {
    $('#party2').DataTable();
    
    // $('#party3').DataTable({
    //   'paging'      : false,
    //   'lengthChange': false,
    //   'searching'   : true,
    //   'ordering'    : true,
    //   'info'        : false,
    //   'autoWidth'   : true
    // })
  });
  // Show the corresponding party div when nav-tab item is clicked
  $(document).on('click', '.partylist', function(e) {
      e.preventDefault();

      // Get the id from the clicked nav-tab item
      var partyId = $(this).data('id');

      // Remove 'active' class from all nav-tab items and add it to the clicked item
      $('.party_li').removeClass('active');
      $(this).parent().addClass('active');

      // Hide all party divs and show the corresponding div
      $('div[id^="party-"]').addClass('hidden');
      $('#party-' + partyId).removeClass('hidden');
      $('#party'+partyId).DataTable();
    });

$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.platform', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'candidates_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.canid);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#posselect').val(response.position_id).html(response.description);      
      $('#partyselect').val(response.partylist_id).html(response.partylist);
      $('.fullname').html(response.firstname+' '+response.lastname);
      $('#desc').html(response.platform);
    }
  });
}
</script>
</body>
</html>
