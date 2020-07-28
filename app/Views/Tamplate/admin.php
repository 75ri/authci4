<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>

<body>


    <!-- sildebar -->
    <div class="wrapper">



        <!-- Sidebar -->
        <nav id="sidebar">
            <ul>user
                <li> <a href="/user">edit user info</a> </li>
                <li><a href="">daftar user</a></li>
                <li><a href="/user/gantipass">Ganti Password</a></li>
            </ul>
            <ul>article
                <li> <a href="">daftar article</a></li>
                <li><a href="">Buat Article</a></li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <?= $this->renderSection('admin') ?>
        </div>

    </div>



</body>

</html>