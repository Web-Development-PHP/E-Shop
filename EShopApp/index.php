<?php
##################################################
#			PHP MVC Framework					 #
#		@author Kristian Lyubenov [Domin1k]		 #
#		<kristian.lubenov@gmail.com>			 #
#	A very basic MVC framework which has  		 #
#	default router for routing schema 			 #
#		/controller/action/parametes.			 #
#	It has one basic wrappers for database 		 #
#	(mysqli) -> object oriented.				 #
#												 #
#	It has default autoloading system			 #
#	which follows pattern :						 #
#	(PHP class name equal folder name)			 #
#                                                #
#                                                #
#		The framework uses PHP 5.6               #
#  Some features might not work on lower versions#
#                                                #
##################################################

?>
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