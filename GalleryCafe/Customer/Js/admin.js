function updateParking() {
    const carSpots = document.getElementById('car-parking').value;
    const bikeSpots = document.getElementById('bike-parking').value;

   
    alert(`Parking updated: ${carSpots} car spots, ${bikeSpots} motorbike spots`);

   }


function updateTables() {
    const seater2 = document.getElementById('seater-2').value;
    const seater4 = document.getElementById('seater-4').value;
    const seater6 = document.getElementById('seater-6').value;

    alert(`Table capacities updated: ${seater2} 2-seaters, ${seater4} 4-seaters, ${seater6} 6-seaters`);
}

function addPromotion() {
    const title = document.getElementById('promotion-title').value;
    const desc = document.getElementById('promotion-desc').value;
    const image = document.getElementById('promotion-image').value;

    alert(`Promotion added: ${title}`);

}

function addUser() {
    const userType = document.getElementById('user-type').value;
    const email = document.getElementById('user-email').value;
    const password = document.getElementById('user-password').value;

    alert(`User added: ${email} (${userType})`);

}
