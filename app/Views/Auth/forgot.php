<?= $this->extend('Tamplate/auth'); ?>
<?= $this->section('auth'); ?>


<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>
<?php endif; ?>
<?= $validation->listErrors(); ?>
<form action="/auth/cekForgot/" method="post">
    <li><input name="email" type="text">Email</li>
    <button type="submit">Kirim</button>
</form>


<?= $this->endSection(); ?>