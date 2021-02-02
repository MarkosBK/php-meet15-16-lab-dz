<?php
$page = $_GET['page'];
?>

<li class="<?php echo ($page == 1) ? 'nav-item nav-item-active' : 'nav-item'; ?>">
    <a class="nav-link" href="index.php?page=1">Catalog</a>
</li>
<li class="<?php echo ($page == 3) ? 'nav-item nav-item-active' : 'nav-item'; ?>">
    <a class="nav-link" href="index.php?page=3">Admin</a>
</li>
<li class="<?php echo ($page == 4) ? 'nav-item nav-item-active' : 'nav-item'; ?>">
    <a class="nav-link" href="index.php?page=4">Reports</a>
</li>