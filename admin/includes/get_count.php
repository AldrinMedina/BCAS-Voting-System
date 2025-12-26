<?php
include 'session.php';

if(isset($_POST['id']))
  $sql = "SELECT * FROM positions ORDER BY priority ASC";
  $query = $conn->query($sql);
  $sql = "SELECT * FROM votes GROUP BY voters_id";
  $vdquery = $conn->query($sql);
  while($row = $query->fetch_assoc()){
    $sql = "SELECT * FROM candidates WHERE position_id = '".$row['id']."'";
    $cquery = $conn->query($sql);
    $carray = array();
    $varray = array();
    while($crow = $cquery->fetch_assoc()){
      $sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
      $vquery = $conn->query($sql);
      array_push($varray, $vquery->num_rows);
      array_push($carray, $crow['lastname'].' '.$varray[0]);
    }
    $carray = json_encode($carray);
    $varray = json_encode($varray);
    $vdquery = json_encode($vdquery->num_rows);


}
?>