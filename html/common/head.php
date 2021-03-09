<?php

/**
 * Adds the header part of the webpage with a customizable title
 * 
 * @param String $title The title to be displayed in the browser tab
 */
function pageHeader($title)
{ ?>
  <!DOCTYPE html>
  <html class="h-100">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <!-- Material icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- FavIcon -->
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/png">
    <link rel="icon" href="../images/favicon.ico" type="image/png">

    <!-- Self included style and scripts -->
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="../client_profile.js" defer></script>

    <title><?= $title ?></title>
  </head>

  <body class="h-100 d-flex flex-column">
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  <?php
}
  ?>