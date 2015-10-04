<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 03.10.2015
 * Time: 22:30
 */

namespace EShop\ViewModels;

use EShop\Helpers\ViewHelpers\FormViewHelper;

class EditUserViewModel extends ViewModel
{
    public function renderChangePasswordForm()
    {
        FormViewHelper::init();
        FormViewHelper::setAttribute('class', 'productForm');
        FormViewHelper::setMethod("post");
        FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'account/changePassword');
        FormViewHelper::initPasswordField()
            ->setName("newPassword")
            ->setAttribute('placeholder', 'New password')
            ->create();
        FormViewHelper::initPasswordField()
            ->setName("confirmPassword")
            ->setAttribute('placeholder', 'Confirm password')
            ->create();
        FormViewHelper::initSubmitButton()
            ->setValue("Change password")
            ->setAttribute('class', 'btn btn-danger')
            ->create();
        FormViewHelper::render();
    }

    public function render()
    {
        $file = '/account/editProfile.php';;
        $this->loadTemplate($file, new EditUserViewModel());
    }
}