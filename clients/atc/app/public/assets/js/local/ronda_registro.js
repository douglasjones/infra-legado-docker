(function () {
    function showMessage(element, status, message) {
        element.className = 'message ' + (status ? 'success' : 'error');
        element.textContent = message;
    }

    var form = document.getElementById('frmRegistroRonda');

    if (!form) {
        return;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var button = document.getElementById('cmdRegistrarRonda');
        var message = document.getElementById('msgRegistroRonda');
        var formData = new FormData(form);

        button.disabled = true;
        button.textContent = 'Registrando...';
        message.className = 'message';
        message.textContent = '';

        fetch('/api/ronda/registrar', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                showMessage(message, data.status === true, data.message || 'Falhou a requisição.');

                if (data.status === true) {
                    form.querySelector('#ds_ronda').value = '';
                }
            })
            .catch(function () {
                showMessage(message, false, 'Falhou a requisição.');
            })
            .finally(function () {
                button.disabled = false;
                button.textContent = 'Registrar Ronda';
            });
    });
}());
