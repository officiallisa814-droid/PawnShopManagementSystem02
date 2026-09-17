<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khmer Pawn System</title>

    <!-- លីងត្រង់ទៅកាន់ CSS ទាំងពីរ -->
    <!-- <link rel="stylesheet" href="<?php echo e(asset('css/layout.css')); ?>"> -->
    <!-- <link rel="stylesheet" href="<?php echo e(asset('css/admin_css/dashboard.css')); ?>"> -->

    <?php echo $__env->yieldPushContent('styles'); ?>
    <!-- លីងត្រង់ទៅកាន់ Icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

</head>
<style>
    /* កំណត់ទម្រង់ដើមដំបូង */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #e9ebee;
    }

    /* រៀបចំប្រអប់ធំឱ្យចេញជា ២ ជួរឈរ (Sidebar ឆ្វេង និង Content ស្ដាំ) */
    /* រៀបចំប្រអប់ធំឱ្យចេញជា ២ ជួរឈរ (Sidebar ឆ្វេង និង Content ស្ដាំ) */
    .dashboard-container {
        display: flex;
        align-items: flex-start;
        /* Crucial: prevents the sidebar from stretching infinitely down */
        min-height: 100vh;
    }

    /* តុបតែង Sidebar ខាងឆ្វេង - Sticky Update */
    .sidebar {
        width: 260px;
        background-color: #0b2240;
        /* ពណ៌ខៀវចាស់ */
        color: #fff;
        padding: 25px 20px;
        display: flex;
        flex-direction: column;

        /* This combination locks the sidebar on scroll */
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        /* Adds an internal scrollbar if your menu has too many items later */
    }


    .sidebar .logo {
        margin-bottom: 35px;
    }

    .sidebar .logo h2 {
        font-size: 22px;
        color: #fff;
    }

    .sidebar .logo p {
        font-size: 12px;
        color: #718096;
    }

    .sidebar .menu-links a {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #a0aec0;
        padding: 12px 15px;
        text-decoration: none;
        margin-bottom: 8px;
        border-radius: 8px;
        font-size: 15px;
        transition: 0.3s;
    }

    .sidebar .menu-links a:hover,
    .sidebar .menu-links a.active {
        background-color: #1e74ff;
        color: #fff;
    }

    /* Pushes the footer div to the absolute bottom of the 100vh flexbox container */
    .sidebar-footer {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #1e293b;
        /* Subtle separation line */
    }

    /* Base styles for the logout action row */
    .sidebar-footer .logout-link {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #f87171;
        /* Soft light red color text */
        padding: 12px 15px;
        text-decoration: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        transition: 0.2s ease;
    }

    /* Attention color changes on layout interaction */
    .sidebar-footer .logout-link:hover {
        background-color: #dc2626;
        /* Strong red alert background background */
        color: #ffffff;
    }






    /* តុបតែងផ្នែកខាងស្ដាំ */
    .main-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .top-header {
        background-color: #fff;
        height: 70px;
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0px 2px 1px #1e74ff;
    }

    .search-bar input {
        padding: 8px 15px;
        width: 300px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        outline: none;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .content-body {
        padding: 30px;
    }
</style>


<body>

    <div class="dashboard-container">

        <!-- ផ្នែក MENU / SIDEBAR (ខាងឆ្វេង) -->
        <aside class="sidebar">
            <div class="logo">
                <h2>Khmer Pawn</h2>
                <p>Pawn Shop System</p>
            </div>
            <nav class="menu-links">
                <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>

                <a href="<?php echo e(route('customer')); ?>" class="<?php echo e(request()->is('customer') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-users"></i> Customer
                </a>

                <a href="<?php echo e(route('pawnItem')); ?>"  class="<?php echo e(request()->is('pawnItem') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-box"></i> Pawn Item
                </a>

                <a href="<?php echo e(route('loanContract')); ?>"  class="<?php echo e(request()->is('loanContract') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-file-contract"></i> Loan Contract
                </a>

                <a href="<?php echo e(route('payments')); ?>" class="<?php echo e(request()->is('payments') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-credit-card"></i> Payments
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="#" class="logout-link">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>

        </aside>

        <!-- ផ្នែកខាងស្ដាំ -->
        <div class="main-wrapper">

            <!-- ផ្នែក HEADER (របារខាងលើ) -->
            <header class="top-header">
                <div class="search-bar">
                    <!-- <input type="text" placeholder="Search..."> -->
                </div>
                <div class="user-profile">
                    <i class="fa-solid fa-bell"></i>
                    <div class="user-info">
                        <h4>Admin</h4>
                        <span>System Administrator</span>
                    </div>
                </div>
            </header>

            <!-- ផ្នែក MAIN CONTENT -->
            <main class="content-body">
                <?php echo $__env->yieldContent('content'); ?>
            </main>

        </div>
    </div>

</body>

</html><?php /**PATH C:\wamp64\www\PawnShopManagementSystemV02\resources\views/layouts/master.blade.php ENDPATH**/ ?>