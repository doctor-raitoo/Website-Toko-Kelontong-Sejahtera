<style>
/* dashboard */
#dashboard_main_container {
    display: flex;
    flex-direction: row;
}

.dashboard_sidebar {
    width: 20%;
    background: #323232;
    height: 100vh;
}

.dashboard_content_container {
    width: 80%;
    background: #f4f6f9;
}

.dashboard_logo {
    color: blue;
    font-size: 50px;
    text-align: center;
}

.dashboard_sidebar_user {
    text-align: center;
    position: relative;
    padding-bottom: 20px;
    border-bottom: 1px solid white;
}

.dashboard_sidebar_user img {
    width: 50px;
    display: inline-block;
    border-radius: 50%;
    border: 2px solid blue;
    margin-right: 5px;
    vertical-align: middle;
}

.dashboard_sidebar_user span { 
    top: 20%;
    font-size: 18px;
    text-transform: uppercase;
    color: white;
    display: inline-block;
}

.dashboard_menu_lists {
    margin-top: 20px;
    padding-left: 0px;
}

.dashboard_menu_lists li.liMainMenu {
    padding-top: 15px;
    list-style: none;
}

.dashboard_menu_lists li.liMainMenu a {
    text-decoration: none;
    color: white;
    display: block;
    font-size: 14px;
    padding: 0px 15px;
    padding-bottom: 15px;
    padding-right: 0px;
}

.dashboard_menu_lists li.liMainMenu a i {
    font-size: 23px;
    width: 30px;
}

.dashboard_menu_lists .menuActive {
    background: blue;
    color: white;
}

.dashboard_menu_lists li:hover {
    background: blue;
    color: white;
    transition: 0.3s all;
}

.subMenu {
    background: blue;
    display: none;
}

.dashboard_menu_lists li.liMainMenu ul.subMenu a.subMenuLink {
    padding-left: 1px !important;
    padding-top: 10px !important;
    padding-bottom: 5px !important;
    font-size: 15px !important;
    color: white !important;
}

.dashboard_menu_lists li.liMainMenu ul.subMenu a.subMenuLink i {
    font-size: 17px !important;
    width: 16px !important;
}

.mainMenuIconArrow {
    float: right;
    font-size: 19px !important;
    margin-top: 7px;
}

</style>
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
            <li class="liMainMenu">
                <a href="dashboard.php"><i class="fa fa-dashboard"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li class="liMainMenu">
                <a href="users_add.php"><i class="fa fa-user-plus"></i><span class="menuText"> Manajemen Produk</span></a>
            </li>
            <li class="liMainMenu">
                <a href="users_add.php"><i class="fa fa-user-plus"></i><span class="menuText"> Manajemen Barang</span></a>
            </li>
            <li class="liMainMenu showHideSubmenu" data-submenu="user">
                <a href="javascript:void(0);" class="showHideSubmenu" data-submenu="user">
                    <i class="fa fa-user-plus showHideSubmenu" data-submenu="user"></i>
                    <span class="menuText showHideSubmenu" data-submenu="user"> Pengguna</span>
                    <i class="fa fa-angle-down mainMenuIconArrow showHideSubmenu" data-submenu="user"></i>
                </a>

                <ul class="subMenu" id="user">
                    <li>
                        <a class="subMenuLink" href="view_users.php">
                            <i class="fa fa-circle-o"></i>
                                <span>Lihat Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a class="subMenuLink" href="view_users.php">
                            <i class="fa fa-circle-o"></i>
                                <span>Tambah Pengguna</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>

<script>
document.addEventListener('click', function(e){
let clickedEl = e.target;
if (clickedEl.closest('.showHideSubmenu')) {
    let targetMenu = clickedEl.dataset.submenu;
    console.log(targetMenu);
}
});
</script>