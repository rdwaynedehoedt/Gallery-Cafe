function logout() {
    fetch('logout.php', {
        method: 'GET',
        credentials: 'include'
    })
    .then(() => {
        window.location.href = 'staffLogin.html'; 
    })
    .catch(error => console.error('Error during logout:', error));
}


document.getElementById('capacity-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const parking_spots = document.getElementById('parking-spots').value;
    const motorbike_spots = document.getElementById('motorbike-spots').value;
    const table_two = document.getElementById('table-two').value;
    const table_four = document.getElementById('table-four').value;
    const table_six = document.getElementById('table-six').value;

    fetch('staff-dashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ` capacity=1&parking-spots=${parking_spots}&motorbike-spots=${motorbike_spots}&table-two=${table_two}&table-four=${table_four}&table-six=${table_six}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Capacity updated successfully!');
            location.reload(); 
        } else {
            alert('Error updating capacity: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

function cancelReservation(bookingId) {
    fetch('staff-dashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
       body: ` action=cancel&booking_id=${bookingId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Reservation canceled successfully!');
            location.reload(); 
        } else {
            alert('Error canceling reservation: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function viewOrder(orderId) {
    fetch('staff-dashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ` action=view_order&order_id=${orderId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(` Order ID: ${data.order.order_id}\nCustomer: ${data.order.customer_name}\nItems:\n${data.order.items}`);
        } else {
            alert('Error fetching order details: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

document.querySelectorAll('.update-status-form').forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const orderId = this.querySelector('input[name="order_id"]').value;
        const orderStatus = this.querySelector('select[name="order_status"]').value;

        fetch('staff-dashboard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: ` update_order=1&order_id=${orderId}&order_status=${orderStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Order status updated successfully!');
                location.reload(); 
            } else {
                alert('Error updating order status: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

const salesChartCtx = document.getElementById('sales-chart').getContext('2d');
const ordersChartCtx = document.getElementById('orders-chart').getContext('2d');

new Chart(salesChartCtx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Sales',
            data: [1200, 1500, 1800, 2200, 2400],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

new Chart(ordersChartCtx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Orders',
            data: [100, 120, 150, 180, 200],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});