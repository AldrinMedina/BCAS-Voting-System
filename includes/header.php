<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>BCAS Voting System</title>
    <link rel="icon" href="images/logo.png" type="image/x-icon">
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<!-- Bootstrap 5 -->
  	<link rel="stylesheet" href="bower_components/bootstrap-5/css/bootstrap.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
  	<!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  	<!-- Font Awesome 4.7 -->
  	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  	<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  	<!--[if lt IE 9]>
  	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  	<![endif]-->

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  	<style>
  		.mt20{
        margin-top: 20px;
      }
      .title{
        font-size: 50px;
      }
      #candidate_list{
        margin-top:20px;
      }

      #candidate_list ul{
        list-style-type:none;
      }

      #candidate_list ul li{ 
        margin:0 30px 30px 0; 
        vertical-align:top
      }

      .clist{
        margin-left: 20px;
      }

      .cname{
        font-size: 25px;
      }

      .votelist{
        font-size: 17px;
      }

      /* Modern Candidate Card Styles */
      .candidate-card {
          transition: all 0.3s ease;
          cursor: pointer;
          border-radius: 16px !important;
          overflow: hidden;
          background: #fff;
      }

      .candidate-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
      }

      .candidate-card.selected {
          border: 3px solid #28a745 !important;
          box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
      }

      .candidate-photo {
          height: 300px;
          object-fit: cover;
          width: 100%;
          transition: transform 0.3s ease;
      }

      .candidate-card:hover .candidate-photo {
          transform: scale(1.05);
      }

      .card-overlay {
          background: linear-gradient(
              to top,
              rgba(0, 0, 0, 0.8) 0%,
              rgba(0, 0, 0, 0.4) 50%,
              transparent 100%
          );
          border-radius: 0 0 16px 16px;
      }

      .candidate-name {
          font-size: 1.25rem;
          text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      }

      .candidate-party .badge {
          font-size: 0.85rem;
          font-weight: 500;
          padding: 0.5rem 1rem;
          border-radius: 20px;
      }

      /* Checkbox/Radio Button Styling */
      .candidate-input {
          width: 1.5rem;
          height: 1.5rem;
          cursor: pointer;
          background: rgba(255, 255, 255, 0.9);
          border: 2px solid #28a745;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      }

      .candidate-input:checked {
          background-color: #28a745;
          border-color: #28a745;
      }

      .candidate-input:focus {
          box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
      }

      /* No Vote Card Styling */
      .no-vote-card {
          border-radius: 16px !important;
          background: #f8f9fa;
          transition: all 0.3s ease;
          cursor: pointer;
          min-height: 300px;
      }

      .no-vote-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
          background: #fff;
      }

      .no-vote-card.selected {
          border-color: #6c757d !important;
          background: #fff;
          box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
      }

      /* Position Section Styling */
      .position-section {
          background: #fff;
          border-radius: 20px;
          padding: 2rem;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
          border: 1px solid #e9ecef;
      }

      .position-title {
          font-size: 2rem;
          color: #2c3e50;
          position: relative;
      }

      .position-title::after {
          content: '';
          position: absolute;
          bottom: -8px;
          left: 0;
          width: 60px;
          height: 4px;
          background: linear-gradient(90deg, #28a745, #20c997);
          border-radius: 2px;
      }

      .position-instruction {
          font-size: 1.1rem;
          margin-top: 0.5rem;
      }

      .position-header {
          border-bottom: 2px solid #f8f9fa;
          padding-bottom: 1.5rem;
      }

      /* Animation classes */
      @keyframes selectPulse {
          0% { transform: scale(1); }
          50% { transform: scale(1.05); }
          100% { transform: scale(1); }
      }

      .candidate-card.just-selected {
          animation: selectPulse 0.3s ease-in-out;
      }

      .invalid-position {
          animation: shake 0.5s ease-in-out;
          border-color: #dc3545 !important;
          box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
      }

      @keyframes shake {
          0%, 100% { transform: translateX(0); }
          25% { transform: translateX(-5px); }
          75% { transform: translateX(5px); }
      }

      /* Loading state */
      .candidate-card.loading {
          opacity: 0.7;
          pointer-events: none;
      }

      .candidate-card.loading::after {
          content: '';
          position: absolute;
          top: 50%;
          left: 50%;
          width: 20px;
          height: 20px;
          border: 2px solid #28a745;
          border-top: 2px solid transparent;
          border-radius: 50%;
          animation: spin 1s linear infinite;
          transform: translate(-50%, -50%);
          z-index: 10;
      }

      @keyframes spin {
          0% { transform: translate(-50%, -50%) rotate(0deg); }
          100% { transform: translate(-50%, -50%) rotate(360deg); }
      }

      /* Responsive Design */
      @media (max-width: 768px) {
          .candidate-photo {
              height: 250px;
          }
          
          .candidate-name {
              font-size: 1.1rem;
          }
          
          .position-title {
              font-size: 1.5rem;
          }
          
          .position-section {
              padding: 1.5rem;
              margin-bottom: 2rem;
          }
          
          .candidate-card:hover {
              transform: translateY(-4px);
          }
      }

      @media (max-width: 576px) {
          .candidate-photo {
              height: 200px;
          }
          
          .position-section {
              padding: 1rem;
              border-radius: 16px;
          }
      }

      /* Fix for Bootstrap 5 + AdminLTE conflicts */
      .alert .btn-close {
          background: transparent;
          border: none;
          font-size: 1.5rem;
          font-weight: 700;
          line-height: 1;
          color: #000;
          text-shadow: 0 1px 0 #fff;
          opacity: .5;
          text-decoration: none;
          cursor: pointer;
      }

      .alert .btn-close:hover {
          opacity: .75;
      }

      /* Ensure Font Awesome 4 compatibility */
      .fa-times-circle {
          font-size: 3rem;
      }

      .fa-info-circle {
          margin-right: 0.5rem;
      }

      .fa-redo {
          margin-right: 0.25rem;
      }

      .fa-check-square-o {
          margin-right: 0.5rem;
      }
  	</style>		
</head>