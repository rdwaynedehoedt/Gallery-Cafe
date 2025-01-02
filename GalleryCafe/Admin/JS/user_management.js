
window.onload = function () {
    loadUsers();
};


function loadUsers() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/load_users.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const users = JSON.parse(xhr.responseText); 
            const tableBody = document.querySelector('#users-table tbody');
            tableBody.innerHTML = ''; 

            users.forEach(function (user) {
                const row = `
                    <tr>
                        <td>${user.name}</td>
                        <td>${user.address}</td>
                        <td>${user.email}</td>
                        <td>${user.contact}</td>
                        <td>
                            <button onclick="openEditUserModal(${user.id})">Edit</button>
                            <button onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            console.error('Error loading users:', xhr.statusText);
        }
    };
    xhr.send();
}


document.getElementById('add-user-btn').addEventListener('click', function () {
    document.getElementById('add-user-modal').style.display = 'block';
});


document.getElementById('close-add-user-modal').addEventListener('click', function () {
    document.getElementById('add-user-modal').style.display = 'none';
});


document.getElementById('add-user-form').addEventListener('submit', function (event) {
    event.preventDefault(); 

    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/add_user.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            document.getElementById('add-user-modal').style.display = 'none';
            loadUsers(); 
        } else {
            console.error('Error adding user:', xhr.statusText);
        }
    };
    xhr.send(formData);
});


function openEditUserModal(userId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/get_user.php?id=' + userId, true); 
    xhr.onload = function () {
        if (xhr.status === 200) {
            const user = JSON.parse(xhr.responseText); 

            
            document.getElementById('edit-user-id').value = user.id;
            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-address').value = user.address;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('edit-contact').value = user.contact;

            
            document.getElementById('edit-user-modal').style.display = 'block';
        } else {
            console.error('Error fetching user data:', xhr.statusText);
        }
    };
    xhr.send();
}


document.getElementById('close-edit-user-modal').addEventListener('click', function () {
    document.getElementById('edit-user-modal').style.display = 'none';
});


document.getElementById('edit-user-form').addEventListener('submit', function (event) {
    event.preventDefault(); 

    const formData = new FormData(this); 
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/update_user.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText); 
            if (xhr.responseText.includes('successfully')) {
                document.getElementById('edit-user-modal').style.display = 'none'; 
                loadUsers(); 
            }
        } else {
            console.error('Error updating user:', xhr.statusText);
        }
    };
    xhr.send(formData); 
});


function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/delete_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText); 
                loadUsers(); 
            } else {
                console.error('Error deleting user:', xhr.statusText);
            }
        };
        
        xhr.send('id=' + encodeURIComponent(userId)); 
    }
}