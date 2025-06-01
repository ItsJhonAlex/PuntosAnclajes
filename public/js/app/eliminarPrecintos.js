document.addEventListener('DOMContentLoaded', function () {
    // Encuentra el elemento de la alerta por su ID
    const alertSuccess = document.getElementById('alert-success');

    // Si existe el elemento de la alerta, ciérralo después de 5 segundos
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.display = 'none';
        }, 5000);
    }
});