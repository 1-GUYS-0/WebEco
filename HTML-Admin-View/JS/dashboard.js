
// Lấy biểu tượng menu từ selector
function getMenuIcon(selector) {
    return document.querySelector(selector);
}

// Khởi tạo hành động chuyển đổi menu khi nhấp vào biểu tượng
function initializeMenuToggle(selectors) {
    const menuContainer = document.querySelector(selectors.containerSelector);
    const menuIcon = getMenuIcon(selectors.iconSelector);

    if (menuIcon) {
        menuIcon.addEventListener('click', () => {
            menuContainer.classList.toggle('show');
        });
    }
}

// Khởi tạo menu với các selector tương ứng
initializeMenuToggle({
    containerSelector: '.container_menu',
    iconSelector: '.menu_logo'
});



// Khởi tạo đối tượng Menu với các phương thức nhỏ bên trong
function Menu(option) {
    const selectModules = document.querySelectorAll(option.selector);
    
    if (selectModules) {
        selectModules.forEach(function(module) {
            module.addEventListener('click', function() {
                option.removeActiveClasses(selectModules);
                option.toggleActiveClasses(module);
            });
        });
    }
}

// Phương thức để loại bỏ class 'active'
Menu.removeActiveClasses = function() {
    return function(selectModules) {
        selectModules.forEach(function(mod) {
            mod.classList.remove('active');
            const textMenu = mod.querySelector('.text_menu');
            if (textMenu) {
                textMenu.classList.remove('active');
            }
        });
    }
}

// Phương thức để thay đổi class của phần tử
Menu.toggleActiveClasses = function() {
    return function(module) {
        module.classList.toggle('active');
        const textMenu = module.querySelector('.text_menu');
        if (textMenu) {
            textMenu.classList.toggle('active');
        }
    }
}

// Triển khai Menu với cấu hình và các phương thức nhỏ bên trong
Menu({
    selector: '.module-menu',
    removeActiveClasses: Menu.removeActiveClasses(),
    toggleActiveClasses: Menu.toggleActiveClasses()
});
