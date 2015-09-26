<?= $model->error ? $model->error : ''; ?>

<h1>Hello <?= $model->user->getUsername(); ?></h1>
<h2>User Info :</h2>
<ul>
    <li>Email: <?= $model->user->getEmail(); ?></li>
    <li>Fullname: <?= $model->user->getFullname(); ?></li>
    <li>Age: <?= $model->user->getAge(); ?></li>
</ul>
