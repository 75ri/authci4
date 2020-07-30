<?= $this->extend('Tamplate/auth'); ?>
<?= $this->section('auth'); ?>


<h1>Silahkan daftar kan diri anda</h1>
<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>
<?php endif; ?>
<?= $validation->listErrors(); ?>

<form method="POST" action="regis">
    <div class="form-group">
        <label for="full_name">full_name</label>
        <input name="full_name" type="full_name" class="form-control" id="full_name" aria-describedby="full_nameinfo" placeholder="Enter email">
        <small id="full_nameinfo" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="password2">Password konfirmasi</label>
        <input name="password2" type="password" class="form-control" id="password2" placeholder="Password konfirmasi">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<ul>
    <li><a href="../auth">login</a></li>
</ul>

<?= $this->endSection(); ?>