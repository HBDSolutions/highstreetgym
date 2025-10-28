<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set $userIsMember for nav menu
$userIsMember = false;
if (
    isset($_SESSION['userID'], $_SESSION['permissionsID']) &&
    $_SESSION['permissionsID'] == 1 // Visitor
) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/highstreetgym/models/database.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/highstreetgym/models/functions.php");
    $userIsMember = user_is_member($conn, $_SESSION['userID']);
}
?>
<header class="header">
    <?php include_once "nav.php"; ?>
    <h1 class="site_title">Hi Street Gym</h1>
    
    <script>
        function toggleMenu() {
            var menu = document.getElementById('main-menu');
            var btn = document.getElementById('menu-btn');
            menu.classList.toggle('show');
            btn.classList.toggle('active');
        }
    </script>
</header>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/highstreetgym/views/login.php"); ?>