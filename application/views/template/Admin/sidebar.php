<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url("assets/bootstrap/css/bootstrap.min.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("assets/css/style.css"); ?>">
  <!-- fontawesome -->
  <link rel="stylesheet" href="<?= base_url("assets/fontawesome/css/all.min.css") ?>">
  <title>Dashboard Admin</title>
  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
  <div class="main-container">
    <div class="sidebar">
      <div class="main-sidebar">
        <div class="header">
          <div class="list-item">
            <img src="<?= base_url("assets/icons/logo.svg") ?>" alt="Logo" class="logo">
            <span class="description-header">ADMIN SISTEM</span>
          </div>
        </div>
        <div class="main">
          <div class="list-item">
            <a href="<?= base_url('admin/dashboard') ?>">
              <img src="<?= base_url("assets/icons/dashboard.svg") ?>" alt="icon" class="icon">
              <span class="description">DASHBOARD</span>
            </a>
          </div>
          <div class="list-item">
            <div>
              <a class="sub-btn">
                <img src="<?= base_url("assets/icons/revenue.svg") ?>" alt="icon" class="icon">
                <span class="description">REVENUE</span>
              </a>
              <!-- dropdown -->
              <div class="sub-menu">
                <a href="<?= base_url('admin/daily') ?>" class="sub-item nav-link text-white font-10px">Daily</a>
              </div>
            </div>
          </div>
          <div class="list-item">
            <a href="<?= base_url('admin/inventory') ?>">
              <img src="<?= base_url("assets/icons/inventory.svg") ?>" alt="icon" class="icon">
              <span class="description">INVENTORY</span>
            </a>
          </div>
        </div>
      </div>
      <a href="<?= base_url('admin/logout') ?>" class="logout">
        <img src="<?= base_url("assets/icons/logout.svg") ?>" alt=" icon" class="icon-logout">
        <span class="description-logout">LOGOUT</span>
      </a>
    </div>