<?php 
    include('includes/header.php');
    $studentId = $_GET['id'];
    $rows =$dbo->GetStudentDetails($studentId);
    var_dump( $rows );