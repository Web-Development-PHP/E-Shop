<div class="row">
    <div class="col-lg-12">
        <div class="well bs-component">
            <form action= "<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/login" method="post" class="form-horizontal">
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
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="formToken" value="<?= \EShop\Helpers\TokenHelper::setCSRFToken(); ?>" />
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <a href="register" class="btn btn-default">Go to register</a>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>