<?php ob_start(); ?>
<?php include("../includes/db.php");?>
<?php include("functions.php"); ?>

<?php session_start(); ?>

<?php 
    if(!isLoggedIn())
    {
        redirect("../index");     

    }else{
        if(!is_admin($_SESSION['username']))
        {
            $pagename = basename($_SERVER['PHP_SELF']);
            $categories = 'categories.php';
            $user = 'users.php';
            if($pagename ==  $categories || $pagename ==  $categories )
            {
                redirect("index");
            }
        }
    }
 ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <script src="js/jquery.js"></script>


</head>

<body>
