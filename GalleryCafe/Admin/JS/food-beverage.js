document.addEventListener("DOMContentLoaded", () => {
    fetchItems();
    fetchCategories();

    
    const addItemModal = document.getElementById('add-item-modal');
    const editItemModal = document.getElementById('edit-item-modal');
    const manageCategoriesModal = document.getElementById('manage-categories-modal');

    const addItemBtn = document.getElementById('add-item-btn');
    const manageCategoriesBtn = document.getElementById('manage-categories-btn');
    const closeButtons = document.querySelectorAll('.close');

    addItemBtn.addEventListener('click', () => addItemModal.style.display = 'block');
    manageCategoriesBtn.addEventListener('click', () => manageCategoriesModal.style.display = 'block');

    closeButtons.forEach(btn => btn.addEventListener('click', () => {
        addItemModal.style.display = 'none';
        editItemModal.style.display = 'none';
        manageCategoriesModal.style.display = 'none';
    }));

    window.onclick = function(event) {
        if (event.target === addItemModal) addItemModal.style.display = 'none';
        if (event.target === editItemModal) editItemModal.style.display = 'none';
        if (event.target === manageCategoriesModal) manageCategoriesModal.style.display = 'none';
    };

    
    document.getElementById('add-item-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_item');

        fetch('../php/fbProcess.php', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchItems();
                fetchCategories();
                addItemModal.style.display = 'none';
                this.reset();
            });
    });

    
    document.getElementById('edit-item-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'edit_item');
        
        fetch('../php/fbProcess.php', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchItems();
                editItemModal.style.display = 'none';
            });
    });

    
    document.getElementById('manage-categories-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_category');

        fetch('../php/fbProcess.php', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fetchCategories();
                this.reset();
            });
    });

    
    document.getElementById('categories-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-category')) {
            const categoryId = e.target.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this category?')) {
                fetch('../php/fbProcess.php?action=delete_category&id=' + categoryId)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchCategories();
                    });
            }
        }
    });

    
    document.querySelector('#items-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-btn')) {
            const itemId = e.target.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this item?')) {
                fetch('../php/fbProcess.php?action=delete_item&id=' + itemId)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchItems();
                    });
            }
        }
    });

    
document.querySelector('#items-table').addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-btn')) {
        const itemId = e.target.getAttribute('data-id');
        
        fetch('../php/fbProcess.php?action=get_item&id=' + itemId)
            .then(response => response.json())
            .then(item => {
                document.getElementById('edit-item-index').value = item.id;
                document.getElementById('edit-item-name').value = item.name;
                document.getElementById('edit-item-category').value = item.category_id;
                document.getElementById('edit-item-description').value = item.description;
                document.getElementById('edit-item-price').value = item.price;
                
                
                const currentImage = document.getElementById('current-item-image');
                currentImage.src = item.image;  
                currentImage.alt = item.name + " image";

                editItemModal.style.display = 'block';
            });
    }
});


    
    function fetchItems() {
        fetch('../php/fbProcess.php?action=fetch_items')
            .then(response => response.json())
            .then(items => {
                let tableBody = '';
                items.forEach(item => {
                    tableBody += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.category_name}</td>
                            <td>${item.description}</td>
                            <td>${item.price}</td>
                            <td><img src="${item.image}" width="100"></td>
                            <td>
                                <button data-id="${item.id}" class="edit-btn">Edit</button>
                                <button data-id="${item.id}" class="delete-btn">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                document.querySelector('#items-table tbody').innerHTML = tableBody;
            });
    }

   
    function fetchCategories() {
        fetch('../php/fbProcess.php?action=get_categories')
            .then(response => response.json())
            .then(categories => {
                const categoriesDropdown = document.getElementById('item-category');
                const editCategoriesDropdown = document.getElementById('edit-item-category');
                const categoriesList = document.getElementById('categories-list');
                
                
                categoriesDropdown.innerHTML = '<option value="">Select Category</option>';
                editCategoriesDropdown.innerHTML = '<option value="">Select Category</option>';
                categoriesList.innerHTML = '';

                
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.category_name;

                    categoriesDropdown.appendChild(option);
                    editCategoriesDropdown.appendChild(option.cloneNode(true));

                    const listItem = document.createElement('li');
                    listItem.innerHTML = ` ${category.category_name} <button class="delete-category" data-id="${category.id}">Delete</button>`;
                    categoriesList.appendChild(listItem);
                });
            });
    }
});