<?= $this->extend('Tamplate/admin'); ?>
<?= $this->section('admin'); ?>

<a href="auth/logout" type="buuton">Keluar</a>
<h1><?= (session()->get('email')); ?> ambil dari sseion</h1>
<h2>haloo</h2>
<pre>
    <?= var_dump($user); ?>
</pre>

<?= $this->endSection(); ?>