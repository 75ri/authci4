<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>

<body>
    <?php
    $db      = \Config\Database::connect();
    ?>

    <div class="wrapper">
        <nav id="sidebar">
            <?php
            $role = session('role');
            $menu = $db->table('user_menu')
                ->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id ')
                ->where(['user_access_menu', 'role_id' =>  $role])
                // ->oederby('asc')
                ->get()->getResultArray();
            ?>
            <?php foreach ($menu as $m) : ?>
                <?php
                $menuId = $m['menu_id'];
                $subMenu =  $db->table('user_menu')
                    ->SELECT('*')
                    ->join('user_sub_menu', 'user_menu.id = user_sub_menu.user_menu_id ')
                    ->where(['user_menu_id' => $menuId])
                    ->get()->getResultArray();
                ?>
                <ol><?= $m['menu'] ?>
                    <?php foreach ($subMenu as $sm) : ?>
                        <li> <a href="<?= $sm['url'] ?>"><?= $sm['title'] ?></a> </li>
                </ol>
            <?php endforeach ?>
        <?php endforeach; ?>

        </nav>

        <!-- Page Content -->
        <div id="content">
            <?= $this->renderSection('admin') ?>
        </div>

    </div>


</body>

</html>