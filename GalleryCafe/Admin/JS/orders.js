document.addEventListener("DOMContentLoaded", function () {
    const ordersTableBody = document.querySelector("#orders-table tbody");
    const updateStatusModal = document.getElementById("update-status-modal");
    const updateStatusForm = document.getElementById("update-status-form");
    const orderStatusSelect = document.getElementById("order-status");
    let currentOrderId;

   
    function fetchOrders() {
        fetch('../Php/fetch_orders.php')
            .then(response => response.json())
            .then(orders => {
                
                ordersTableBody.innerHTML = '';

                
                orders.forEach(order => {
                    const row = document.createElement('tr');
                    const itemsList = order.items.map(item => ` ${item.name} (x${item.quantity})`).join(", ");

                    row.innerHTML = `
                        <td>${order.order_id}</td>
                        <td>${order.customer_name}</td>
                        <td>${itemsList}</td>
                        <td>Rs. ${order.total}</td>
                        <td>${order.order_status}</td>
                        <td><button class="update-status-btn" data-order-id="${order.order_id}" data-order-status="${order.order_status}">Update Status</button></td>
                    `;

                    ordersTableBody.appendChild(row);
                });

                
                document.querySelectorAll(".update-status-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        currentOrderId = this.dataset.orderId;
                        orderStatusSelect.value = this.dataset.orderStatus;
                        updateStatusModal.style.display = "block";
                    });
                });
            })
            .catch(error => console.error('Error fetching orders:', error));
    }


    function closeModal() {
        updateStatusModal.style.display = "none";
    }


    document.querySelector(".close").addEventListener("click", closeModal);


    updateStatusForm.addEventListener("submit", function (e) {
        e.preventDefault();

 
        fetch('../Php/update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'order_id': currentOrderId,
                'order_status': orderStatusSelect.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                closeModal();
                fetchOrders(); 
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error updating order status:', error));
    });

 
    fetchOrders();
});