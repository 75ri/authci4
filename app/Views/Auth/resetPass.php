<?= $this->extend('Tamplate/auth'); ?>
<?= $this->section('auth'); ?>


<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>
<?php endif; ?>
<?= $validation->listErrors(); ?>
<form action="/auth/CekResetPass" method="post">
    <li><input name="password1" type="text">Password</li>
    <li><input name="password2" type="text">Konfirmasi Passsword</li>
    <li><input name="email" hidden value="<?= $email ?>"></li>

    <button type="submit">Kirim</button>
</form>


<?= $this->endSection(); ?>