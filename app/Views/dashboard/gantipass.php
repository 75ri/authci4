<?= $this->extend('Tamplate/admin'); ?>
<?= $this->section('admin'); ?>


<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>
<?php endif; ?>
<?= $validation->listErrors() ?>

<form method="post" action="ubahpass">
    <li><input name="password" type="text">password sekarang</li>
    <li><input name="passwordBaru" type="text">password baru</li>
    <li><input name="passwordUlangi" type="text">ulangi password baru </li>
    <button type="submit">Simpan</button>
</form>




<?= $this->endSection(); ?>