document.addEventListener('DOMContentLoaded', () => {
    
    const menuLinks = document.querySelectorAll('.sidebar .menu li a');
    const contentSections = document.querySelectorAll('.main-content .content');

    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            const targetId = link.getAttribute('href').substring(1);

            
            contentSections.forEach(section => {
                section.classList.remove('active');
            });

            
            document.getElementById(targetId).classList.add('active');
        });
    });

    
    document.getElementById('dashboard').classList.add('active');

    
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');

    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2],
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

    new Chart(ordersCtx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Pending', 'Cancelled'],
            datasets: [{
                label: 'Orders',
                data: [55, 25, 20],
                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        }
    });
});

function logout() {
    window.location.href = 'logout.php'; 
}

function showUserForm() {
    document.getElementById('user-form').classList.toggle('hidden');
}

function showFoodForm() {
    document.getElementById('food-form').classList.toggle('hidden');
}
