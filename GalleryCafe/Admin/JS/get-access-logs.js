document.addEventListener('DOMContentLoaded', () => {
    
    fetch('get-access-logs.php')
        .then(response => response.json())
        .then(data => {
            const logsTableBody = document.querySelector('#logs-table tbody');
            data.forEach(log => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${log.id}</td>
                    <td>${log.admin_username}</td>
                    <td>${log.action}</td>
                    <td>${log.ip_address}</td>
                    <td>${log.status}</td>
                    <td>${log.timestamp}</td>
                `;
                logsTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching access logs:', error));
});
