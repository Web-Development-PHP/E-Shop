<?php /** * @var \EShop\ViewModels\HomeViewModel */  ?>

<div class="row">
    <div class="col-lg-12">
        <div class="well bs-component">
            <form action="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/register" method="post" class="form-horizontal">
                <fieldset>
                    <legend>Login</legend>
                    <div class="form-group">
                        <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="username" id="inputUsername" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputConfirmPassword" class="col-lg-2 control-label">Confirm Password</label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" name="confirmPassword" id="inputConfirmPassword" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-6">
                            <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email">
                        </div>
                    </div>
                    <input type="hidden" name="formToken" value="<?= \EShop\Helpers\TokenHelper::getCSRFToken(); ?>" />
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <a href="login" class="btn btn-default">Go to login</a>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>