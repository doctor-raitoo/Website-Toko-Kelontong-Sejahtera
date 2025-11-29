<div class="dashboard_sidebar" id="dashboard_sidebar">
    <h1 class="dashboard_logo" id="dashboard_logo">
        STOKS
    </h1>
    <div class="dashboard_sidebar_user">
        <img src="image/profile.jpg" alt="Profil pengguna" id="userImage" />
        <span>
            <?= $user['nama_depan'] . ' ' . $user['nama_belakang'] ?>
        </span>
    </div>
    <div class="dashboard_sidebar_menu">
        <ul class="dashboard_menu_lists">
            <!-- class="menuActive" -->
            <li>
                <a href="dashboard.php"><i class="fa fa-dashboard"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li class="">
                <a href="users_add.php"><i class="fa fa-user-plus"></i><span class="menuText"> Pengguna</span></a>
            </li>
        </ul>
    </div>
</div>