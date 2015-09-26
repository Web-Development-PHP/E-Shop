<?= $model->error ? $model->error : ''; ?>

<form action="" method="post">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="password" name="confirmPassword">
    <input type="text" name="email">
    <input type="submit" value="Register!">
</form>