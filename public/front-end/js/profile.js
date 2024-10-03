document.getElementById('avatarInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

function editInfo(field) {
    const newValue = prompt(`Enter new ${field}:`);
    if (newValue) {
        const infoDiv = document.querySelector(`.info div:contains(${field.charAt(0).toUpperCase() + field.slice(1)})`);
        infoDiv.childNodes[0].nodeValue = `${field.charAt(0).toUpperCase() + field.slice(1)}: ${newValue} `;
    }
}

function showTab(tabName) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-content > div').forEach(content => content.classList.remove('active'));

    document.querySelector(`.tab[onclick="showTab('${tabName}')"]`).classList.add('active');
    document.querySelector(`.${tabName}`).classList.add('active');
}

function confirmReceived() {
    alert('Order confirmed as received.');
}