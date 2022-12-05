<div class="menu" role="navigation">
    <span class="logo">
        <a href="index.php">ParkingFinder</a>
    </span>
    <a <?php echo ($active === 'search' ? 'class="active"' : ''); ?> href="search.php">Search</a>
    <a <?php echo ($active === 'submission' ? 'class="active"' : ''); ?> href="submission.php">Submit</a>
    <a <?php echo ($active === 'login' ? 'class="active"' : ''); ?> href="login.php">Login</a>
    <a <?php echo ($active === 'register' ? 'class="active"' : ''); ?> href="registration.php">Register</a>
</div>
<br>