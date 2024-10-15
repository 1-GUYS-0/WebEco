
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
        selectModules.forEach(function (module) {
            module.addEventListener('click', function () {
                option.removeActiveClasses(selectModules);
                option.toggleActiveClasses(module);
            });
        });
    }
}

// Phương thức để loại bỏ class 'active'
Menu.removeActiveClasses = function () {
    return function (selectModules) {
        selectModules.forEach(function (mod) {
            mod.classList.remove('active');
            const textMenu = mod.querySelector('.text_menu');
            if (textMenu) {
                textMenu.classList.remove('active');
            }
        });
    }
}

// Phương thức để thay đổi class của phần tử
Menu.toggleActiveClasses = function () {
    return function (module) {
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

// hàm tìm kiếm
function search(idTable) {
    console.log('search');
    const searchInput = document.getElementById('inputSearch');
    const table = document.getElementById(idTable);
    const rows = table.getElementsByTagName('tr');
    const filters = searchInput.value.toLowerCase().split(',').map(filter => filter.trim());
    console.log(filters);
    for (let i = 1; i < rows.length; i++) { // Bỏ qua hàng tiêu đề
        const cells = rows[i].getElementsByTagName('td');
        let match = true;

        for (let k = 0; k < filters.length; k++) {
            let filterMatch = false;
            for (let j = 1; j < cells.length; j++) {
                if (cells[j]) {
                    const cellValue = cells[j].textContent || cells[j].innerText;
                    if (cellValue.toLowerCase().indexOf(filters[k]) > -1) {
                        filterMatch = true;
                        break;
                    }
                }
            }
            if (!filterMatch) {
                match = false;
                break;
            }
        }
        rows[i].style.display = match ? '' : 'none'; 
    }
};
// //Thực hiện việc lấy thông tin các giá trị input từ form
// function FormData(selector) {
//     const inputwrap = document.querySelectorAll(selector.input);
    
//     if (inputwrap){
//         const Forms = FormData.SelectForm();
//         if (Forms){
//             Forms.onsubmit = function (event) { //Xác định khi nút được submit mới tiến hàng lấy data, đồng thời đã get được 'form'
//                 event.preventDefault(); // ngăn không cho form được gữi đi
//                 const inputs = Forms.querySelectorAll("input");
//                 inputs.forEach(function (input) {
//                     console.log(input.id, '=', input.value)
//                 })
//             }
//         }
//     }
// }
// // Lấy các thẻ form chứa input
// FormData.SelectForm = function () {
//     const getform = document.querySelector("form");
//     return getform
// }
// FormData({
//     input: '.wrap_input',
//     SelectForm: FormData.SelectForm(),//Có thể bỏ vì chỉ là yếu tố phát triển chức năng lúc ban đầu
// })
