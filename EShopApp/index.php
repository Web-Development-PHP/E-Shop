<div class="container">
<?php
    error_reporting(E_ALL ^ E_NOTICE);
    require_once '../Framework/App.php';
    include_once 'Views/public/navbar.php';
    $app = new \EShop\App();
    $app->start();
    include_once 'Views/public/footer.php';
?>
</div>

<div id="ajaxContent"></div>