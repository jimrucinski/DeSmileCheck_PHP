<?php
    include('includes/CustomException.class.php');
    include('includes/arrays.php');
    $connInfo = include('conf/DbConf.php');
    include('includes/SingleDB.class.php');
    include('includes/functions.php');
    include('includes/School.class.php');
    include('includes/Student.class.php');
    include('includes/Screening.class.php');
    include('includes/Exam.class.php');

    $positiveMessages="";
    $negativeMessages="";
   try
   {
        $dbo = SingleDB::getInstance();
        $dbo->connect($connInfo->host,$connInfo->username,$connInfo->pass,$connInfo->database);
        
   }
   catch(customException $e){

       $errorMsg =  $e->errorMessage();
   }
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="/SmileCheckDe/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/SmileCheckDe/bootstrap-3.3.7-dist/css/bootstrap.css" media="screen">
    <!--<link rel="stylesheet" href="/SmileCheckDe/bootstrap-3.3.7-dist/css/bootstrap.min.css">-->
    <script src="/SmileCheckDe/js/maskedinput.js"></script>
    <link rel="stylesheet" href="/SmileCheckDe/css/smile.css" media="screen">
    
</head>
    <title></title>
</head>
<body>
    <div>
        <div class="container">
            <?php include('includes/nav.php'); ?>

            
            
            
    



        