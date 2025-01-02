function goBackToMenu() {
    window.location.href = '../Pages/menu.php';
}

document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('input', function() {
        const itemId = this.dataset.id;
        const newQuantity = this.value;
        updateCartQuantity(itemId, newQuantity);
        updateTotal();
    });
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const quantity = item.querySelector('.quantity').value;
        const price = item.querySelector('.quantity').dataset.price;
        total += quantity * price;
    });
    document.getElementById('total').textContent = total.toFixed(2);
}

function removeItem(itemId) {
    fetch('../Pages/remove_from_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ 'item_id': itemId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('item-' + itemId).remove();
            updateTotal();
        } else {
            alert(data.message);
        }
    });
}

function placeOrder() {
    fetch('../Pages/place_order.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Order placed! Order ID: ' + data.order_id);
        } else {
            alert(data.message);
        }
    });
}
updateTotal();