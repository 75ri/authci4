<?= $this->extend('Tamplate/admin'); ?>
<?= $this->section('admin'); ?>
<h1>Halaman home</h1>
<ul>
    <li><a href="auth">Login</a> </li>
</ul>



<form action="/coba">
    <li><input name="nama" type="text">Nama</li>
    <li><button type="submit">simpan</button></li>
</form>


<table style="border: 1px solid black;" class="table table-hover">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>

    </thead>
    <?php foreach ($nama as $n) : ?>
        <tbody>
            <tr>
                <td><?= $n['nama'] ?></td>
                <td>
                    <li><a href="/edit">edit</a></li>
                </td>
            </tr>
        </tbody>
    <?php endforeach; ?>
</table>



<?= $this->endSection(); ?>