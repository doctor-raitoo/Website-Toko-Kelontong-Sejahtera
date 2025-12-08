<?php 
    $user = $_SESSION['user'];
?>

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #dashboard_main_container {
        display: flex;
        flex-direction: row;
        height: 100vh;
    }

    .dashboard_sidebar {
        width: 20%;
        background: #323232;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
    }

    .dashboard_content_container {
        width: 80%;
        background: #f4f6f9;
        margin-left: 20%;
        width: 80%;
    }

    .dashboard_logo {
        color: blue;
        font-size: 50px;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .dashboard_sidebar_user {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px solid white;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .dashboard_sidebar_user img {
        width: 60px;
        border-radius: 50%;
        border: 2px solid lightgray;
        margin-bottom: 10px;   /* Jarak foto ke nama */
    }

    .dashboard_sidebar_user span { 
        font-size: 16px;
        text-transform: uppercase;
        color: white;
        margin-top: 5px;        /* Opsional */
    }

    .dashboard_menu_lists {
        margin-top: 20px;
        padding-left: 0px;
    }


    .dashboard_menu_lists li.liMainMenu {
        padding-top: 20px;
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
        background: #0f46e0ff;
        display: none;
        padding: 0;
        margin: 0;
    }

    .subMenu li {
        list-style: none;
    }


    .dashboard_menu_lists li.liMainMenu ul.subMenu a.subMenuLink {
        display: flex;
        align-items: center;
        padding: 10px 25px;
        font-size: 15px;
        color: white !important;
        text-decoration: none;
        width: 100%;
    }

    .dashboard_menu_lists li.liMainMenu ul.subMenu a.subMenuLink:hover {
        background: #154ff0;
        transition: 0.2s;
    }

    .dashboard_menu_lists li.liMainMenu ul.subMenu a.subMenuLink i {
        width: 20px;
        text-align: center;
        margin-right: 12px;
        font-size: 17px !important;
    }


    .mainMenuIconArrow {
        float: right;
        font-size: 19px !important;
        margin-top: 7px;
    }

    .subMenuActive {
        background: #002c8c;
        border-left: 4px solid white;
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
            <li class="liMainMenu showHideSubmenu" >
                <a href="javascript:void(0);" class="showHideSubmenu" >
                    <i class="fa fa-tag showHideSubmenu" ></i>
                    <span class="menuText showHideSubmenu" > Produk</span>
                    <i class="fa fa-angle-down mainMenuIconArrow showHideSubmenu" ></i>
                </a>

                <ul class="subMenu">
                    <li>
                        <a class="subMenuLink" href="product_view.php">
                            <i class="fa fa-circle-o"></i>
                                <span>Lihat Produk</span>
                        </a>
                    </li>
                    <li>
                        <a class="subMenuLink" href="product_add.php">
                            <i class="fa fa-circle-o"></i>
                                <span>Tambah Produk</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="liMainMenu showHideSubmenu">
                <a href="javascript:void(0);" class="showHideSubmenu">
                <i class="fa fa-shopping-cart showHideSubmenu"></i>
                <span class="menuText showHideSubmenu"> Transaksi</span>
                <i class="fa fa-angle-down mainMenuIconArrow showHideSubmenu"></i>
            </a>
            <ul class="subMenu">
                <li>
                    <a class="subMenuLink" href="transaction_view.php">
                        <i class="fa fa-circle-o"></i>
                        <span>Lihat Transaksi</span>
                    </a>
                </li>
                <li>
                    <a class="subMenuLink" href="transaction_add.php">
                        <i class="fa fa-circle-o"></i>
                        <span>Tambah Transaksi</span>
                    </a>
                </li>
            </ul>
        </li>
            <li class="liMainMenu showHideSubmenu" >
                <a href="javascript:void(0);" class="showHideSubmenu" >
                    <i class="fa fa-user-plus showHideSubmenu" ></i>
                    <span class="menuText showHideSubmenu" > Pengguna</span>
                    <i class="fa fa-angle-down mainMenuIconArrow showHideSubmenu" ></i>
                </a>

                <ul class="subMenu">
                    <li><a class="subMenuLink" href="users_view.php"><i class="fa fa-circle-o"></i> Data Pengguna</a></li>
                    <li><a class="subMenuLink" href="users_add.php"><i class="fa fa-circle-o"></i> Tambah Pengguna</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<script>

document.addEventListener('click', function(e){
    let clickedEl = e.target;

    if (clickedEl.classList.contains('showHideSubmenu')) {
        let subMenu = clickedEl.closest('li').querySelector('.subMenu');
        let mainMenuIcon = clickedEl.closest('li').querySelector('.mainMenuIconArrow');

        let subMenus = document.querySelectorAll('.subMenu');
        subMenus.forEach((sub) => {
            if (subMenu !== sub) sub.style.display = 'none';
        });

        showHideSubmenu(subMenu, mainMenuIcon);
    }
});

function showHideSubmenu(subMenu, mainMenuIcon){
    
    if (subMenu != null){
        if (subMenu.style.display === 'block') {
            subMenu.style.display = 'none';
            mainMenuIcon.classList.remove('fa-angle-up');
            mainMenuIcon.classList.add('fa-angle-down');
        } else {
            subMenu.style.display = 'block';
            mainMenuIcon.classList.remove('fa-angle-down');
            mainMenuIcon.classList.add('fa-angle-up');
        }
    }
}

let pathArray = window.location.pathname.split( '/' );
let curFile = pathArray[pathArray.length - 1];

let curNav = document.querySelector('a[href="' + curFile +'"]');
curNav.closest('li').classList.add('subMenuActive');

let mainNav = curNav.closest('.liMainMenu');
mainNav.style.background='blue';

let subMenu = curNav.closest('.subMenu');
let mainMenuIcon = mainNav.querySelector('.mainMenuIconArrow');

console.log(mainMenuIcon);

showHideSubmenu(subMenu, mainMenuIcon);

console.log(mainNav);

</script>
