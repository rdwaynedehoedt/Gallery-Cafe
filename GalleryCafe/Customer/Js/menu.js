let currentPage = 1;
const itemsPerPage = 12;
let menuItems = [];

function displayMenuItems(menuItems) {
    const menuBox = document.querySelector('.menu-box');

    menuItems.forEach(item => {
        const menuCard = document.createElement('div');
        menuCard.classList.add('menu-card');

        menuCard.innerHTML = `
            <img src="${item.image}" alt="${item.name}" onerror="this.onerror=null; this.src='../Image/default.png';">
            <h4>${item.name}</h4>
            <p>${item.description}</p>
            <span>Rs.${item.price}</span>
            <button class="add-to-cart-btn" data-item-id="${item.id}" ${isLoggedIn ? '' : 'disabled'}>Add to Cart</button>
            <p class="category-name">Category: ${item.category_name}</p>
        `;

        menuBox.appendChild(menuCard);
    });

    attachAddToCartListeners();
}

function displayMenuItemsPaginated(items, page = 1) {
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedItems = items.slice(startIndex, endIndex);

    document.querySelector('.menu-box').innerHTML = ''; 
    displayMenuItems(paginatedItems);
    document.getElementById('pageNumber').innerText = ` Page ${page}`;
    document.getElementById('prevPage').disabled = page === 1;
    document.getElementById('nextPage').disabled = endIndex >= items.length;
}


fetch('../php/fetch_menu_items.php')
    .then(response => response.json())
    .then(items => {
        menuItems = items;
        displayMenuItemsPaginated(menuItems, currentPage);
    })
    .catch(error => console.error('Error fetching menu items:', error));

document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        displayMenuItemsPaginated(menuItems, currentPage);
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    if (currentPage * itemsPerPage < menuItems.length) {
        currentPage++;
        displayMenuItemsPaginated(menuItems, currentPage);
    }
});

function attachAddToCartListeners() {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!isLoggedIn) {
                alert("You need to log in to add items to the cart.");
                return; 
            }

            const itemId = this.dataset.itemId;
            const quantity = 1;

           
            fetch('../Pages/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'item_id': itemId,
                    'quantity': quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    updateCartCount(); 
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
}

function updateCartCount() {
    fetch('fetch_cart.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cartCount').innerText = data.cart_count;
        })
        .catch(error => console.error('Error fetching cart count:', error));
}

updateCartCount();