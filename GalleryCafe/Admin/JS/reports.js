document.addEventListener('DOMContentLoaded', () => {
   
    function openTab(tabName) {
        const tabContents = document.querySelectorAll('.tabcontent');
        tabContents.forEach(content => content.classList.remove('active'));

        const tabLinks = document.querySelectorAll('.tablink');
        tabLinks.forEach(link => link.classList.remove('active'));

        document.getElementById(tabName).classList.add('active');
    }

   
    const tabLinks = document.querySelectorAll('.tablink');
    tabLinks.forEach(link => {
        link.addEventListener('click', function () {
            openTab(this.dataset.tab);
            tabLinks.forEach(tab => tab.classList.remove('active'));
            this.classList.add('active');
        });
    });

   
    document.querySelector('.tablink').click();

   
    const salesChartCtx = document.getElementById('sales-chart').getContext('2d');
    const inventoryChartCtx = document.getElementById('inventory-chart').getContext('2d');

   
    const salesChart = new Chart(salesChartCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: [{
                label: 'Sales',
                data: [1200, 1900, 3000, 5000, 2500],
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

   
    const inventoryChart = new Chart(inventoryChartCtx, {
        type: 'pie',
        data: {
            labels: ['Pizza', 'Burger', 'Pasta', 'Salad', 'Drinks'],
            datasets: [{
                label: 'Inventory',
                data: [30, 50, 20, 15, 25],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        }
    });

   
    document.getElementById('generate-sales-report').addEventListener('click', () => {
        alert('Sales report generated!');
   
    });

   
    document.getElementById('generate-inventory-report').addEventListener('click', () => {
        alert('Inventory report generated!');
     });
});
