<?= $this->extend('Tamplate/auth'); ?>
<?= $this->section('auth'); ?>


<h1>Silahkan daftar kan diri anda</h1>

<form method="POST" action="regis">
    <div class="form-group">
        <label for="full_name">full_name</label>
        <input name="full_name" type="full_name" class="form-control" id="full_name" aria-describedby="full_nameinfo" placeholder="Enter email">
        <small id="full_nameinfo" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<ul>
    <li><a href="../auth">login</a></li>
</ul>

<?= $this->endSection(); ?>