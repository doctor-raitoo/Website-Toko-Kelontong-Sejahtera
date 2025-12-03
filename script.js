var sidebarIsOpen = true; 
toggleBtn.addEventListener('click', (event) => {
    event.preventDefault();
    if (sidebarIsOpen) {
        dashboard_sidebar.style.width = '10%';
        dashboard_sidebar.style.transition = '0.3s all';
        dashboard_content_container.style.width = '90%';
        dashboard_logo.style.fontSize = '30px';
        userImage.style.width = '30px';
        let menuTexts = document.getElementsByClassName('menuText');
        for (var i = 0; i < menuTexts.length; i++) 
            {
                menuTexts[i].style.display = 'none';
            }
            console.log(menuTexts);
            document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
            sidebarIsOpen = false;
        } else {
            dashboard_sidebar.style.width = '20%';
            dashboard_content_container.style.width = '80%';
            dashboard_logo.style.fontSize = '50px';
            userImage.style.width = '50px';
            let menuTexts = document.getElementsByClassName('menuText');
            for (var i = 0; i < menuTexts.length; i++)
            {
                menuTexts[i].style.display = 'inline-block';
            }
            console.log(menuTexts);
            document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'left';
            sidebarIsOpen = true;
        }
    }
);
