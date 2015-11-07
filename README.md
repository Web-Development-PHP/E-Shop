# E-Shop - Framework

A simple MVC Framework written in PHP 5.5 created by Kristain Lyubenov (Domin1k) kristian.lubenov@gmail.com

The framework has default router which routes actions in the pattern:
/hostname/controller/action/params

It also supports custom routes via the attribute @Route("") and custom areas (all you need to do is add folder with controllers in the root Areas folder)

You specify the pattern which matches the URI. The controller to be loaded. And the method to be invoked. 

The .htaccess file content this rewrite rules. Your webserver has to be configured to rewrite urls. (mod_rewrite for Apache)

To create a page, you need the following things:

A controller in the Controllers folder which follows the namespace and extends Controller (i.e. MyPage)
A non-static public method in it (i.e. myFirstAction())
A folder in Views directory which is named after the controller (mypage)

You can add <?php /* @var $this \ANSR\View */ ?> at the top of each template, to recieve auto-completion from your IDE. This will bring you an auto-completion of the public methods in the View object.

To use a Model:
-Create a model in Models folder which extends the Model abstract class (i.e. ProductsModel);
The framework supports strongly typed views and escape of the bad characters by default.
-If you need a View to be strongly typed all you need to do is add the expected Model at the first line of the view
(i.e. <?php /** * @var \EShop\Models\Category */  ?>)

Feel free to change configurations of Database, Autoloading, Routing, etc (better add new classes)
