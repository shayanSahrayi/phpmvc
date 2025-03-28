<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد مدیریتی</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= assets("css/admin/style.css") ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= assets("css/persian-datepicker.min.css") ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@latest/dist/css/persian-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- اضافه کردن فایل تم Bootstrap برای Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <!-- هدر -->
    <div class="header">
        <div class="profile d-none d-lg-flex">
            <i class="fa fa-bell fa-lg mx-3"></i>
            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="پروفایل">
            <span>نام کاربر</span>
        </div>
        <div>
            <button class="btn btn-light">مشاهده حساب</button>
            <button class="btn btn-danger">خروج</button>
        </div>
        <!-- دکمه همبرگر برای موبایل -->
        <button class="btn btn-light hamburger d-lg-none" id="sidebarToggle">
            <i class="fa fa-bars"></i>
        </button>
    </div>

    <!-- سایدبار -->
    <div class="sidebar">
        <h5><a href="<?=url('admin')?>" class="d-block">داشبورد</a></h5>
        <ul class="nav flex-column">
            <!-- منو اول -->
            <li class="nav-item">
                <a href="#" class="nav-link toggle-menu">
                    <i class="fa fa-users fa-lg"></i> کاربران <i class="fa fa-angle-down"></i>
                </a>
                <div class="submenu">
                    <a href="<?= url("admin/users") ?>"><i class="fa fa-eye"></i> مشاهده کاربران</a>
                    <a href="<?= url("admin/users/create") ?>"><i class="fa fa-user-plus"></i> ایجاد کاربران جدید</a>
                </div>
            </li>
            <!-- منو دوم -->
            <li class="nav-item">
                <a href="#" class="nav-link toggle-menu">
                    <i class="fa fa-credit-card fa-lg"></i> شهریه ها <i class="fa fa-angle-down"></i>
                </a>
                <div class="submenu">
                    <a href="<?= url('admin/tuitions') ?>"><i class="fa fa-money-bill-wave"></i> مشاهده شهریه</a>
                    <a href="<?= url('admin/tuitions/create') ?>"><i class="fa fa-plus-circle"></i> ایجاد شهریه جدید</a>
                    <!-- <a href="#"><i class="fa fa-chart-line"></i> گزارش گیری شهریه</a> -->
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link toggle-menu">
                    <i class="fa fa-cog fa-lg"></i> سانس ها <i class="fa fa-angle-down"></i>
                </a>
                <div class="submenu">
                    <a href="<?= url('admin/times') ?>"><i class="fa fa-toolbox"></i> مشاهده سانس ها</a>
                    <a href="<?= url('admin/times/create') ?>"><i class="fa fa-sliders-h"></i> ایجاد سانس جدید</a>
                    <!-- <a href="#"><i class="fa fa-chart-line"></i> گزارش گیری شهریه</a> -->
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link toggle-menu">
                    <i class="fa fa-inbox fa-lg"></i> پیامک ها <i class="fa fa-angle-down"></i>
                </a>
                <div class="submenu">
                    <a href="<?= url('admin/sms') ?>"><i class="fa fa-chart-bar"></i> مشاهده پیامک ها</a>
                    <a href="<?= url('admin/sms/create') ?>"><i class="fa fa-plus-circle"></i> ایجاد پیامک جدید</a>
                    <!-- <a href="#"><i class="fa fa-chart-line"></i> گزارش گیری شهریه</a> -->
                </div>
            </li>
        </ul>
    </div>

    <!-- محتوا -->
    <div class="main-content">