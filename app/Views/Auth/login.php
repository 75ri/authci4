<?= $this->extend('Tamplate/auth'); ?>
<?= $this->section('auth'); ?>


<h1>Silahkan Login</h1>
<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>

<?php endif; ?>
<?= $validation->listErrors(); ?>
<form action="/auth/login" method="post">
    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">remember me</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<ul>
    <li><a href="/auth/register">register</a></li>
    <li><a href="/auth/forgot">forgot</a></li>
</ul>


<?= $this->endSection(); ?>