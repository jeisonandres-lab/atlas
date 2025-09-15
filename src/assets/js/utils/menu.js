const menusItemsDropDown = document.querySelectorAll('.menu-item-dropdown');
const menuItemsStatic = document.querySelectorAll('.menu-item-static');
const menuBtn = document.getElementById('menu-btn');
const sidebar = document.getElementById('sidebar');
const sidebarBtn = document.getElementById('sidebar-btn');
const darkModeBtn = document.getElementById('dark-mode-btn');

darkModeBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
});

sidebarBtn.addEventListener('click', () => {
    document.body.classList.toggle('sidebar-hidden');
});

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('minimize'); 
    console.log('click');
    // menuBtn.classList.toggle('menu-btn-toggle');
});

menusItemsDropDown.forEach((menuItem)=>{
    menuItem.addEventListener('click', ()=>{
        const subMenu = menuItem.querySelector('.sub-menu');
        const isActive = menuItem.classList.toggle('sub-menu-toggle');
        if(subMenu){
            if(isActive){
                subMenu.style.height = `${subMenu.scrollHeight + 6}px`;
                subMenu.style.padding = '0.2rem 0';
            }else{
                subMenu.style.height = '0';
                subMenu.style.padding = '0';
            }
        }

        menusItemsDropDown.forEach((item)=>{
            if(item != menuItem){
                const otherSubmenu = item.querySelector('.sub-menu');
                if(otherSubmenu){
                    item.classList.remove('sub-menu-toggle');
                    otherSubmenu.style.height = '0';
                    otherSubmenu.style.padding = '0';
                }
            }
        });
    });
});

menuItemsStatic.forEach((menuItem)=>{
    menuItem.addEventListener('mouseenter', ()=>{
        if(!sidebar.classList.contains('minimize')) return;

        menusItemsDropDown.forEach((item)=>{
            const otherSubmenu = item.querySelector('.sub-menu');
            if(otherSubmenu){
                item.classList.remove('sub-menu-toggle');
                otherSubmenu.style.height = '0';
                otherSubmenu.style.padding = '0';
            }
        });
    });
});

// // 2. Verificar si el sidebar tiene la clase 'minimize'
// if (sidebar.classList.contains('minimize')) {
//   // Si la tiene, establece el padding del elemento del usuario
//   document.getElementById("userActivo").style.padding = '80px';
//   console.log('El sidebar está minimizado, se ha ajustado el padding del usuario.');
// } 

// function checkWindowSize() {
//     sidebar.classList.remove('minimize');
// }

// checkWindowSize();
// window.addEventListener('resize', checkWindowSize);