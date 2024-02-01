

  //Validation Form
  (function() {
    'use strict';

    // Buscar todos los formularios que tienen la clase 'needs-validation'
    const forms = document.querySelectorAll('.needs-validation');

    // Iterar sobre los formularios y prevenir la presentación si no son válidos
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
})();


document.addEventListener('DOMContentLoaded', function () {
    // Obtén el select y los campos que deseas activar/desactivar
    const ubicacionLaboralSelect = document.querySelector('select[name="ubicacionLaboral"]');
    const anydeskInput = document.getElementById('Anydesk');
    const proveedorInternetInput = document.getElementById('Pinternet');

    // Agrega un evento de cambio al select
    ubicacionLaboralSelect.addEventListener('change', function () {
        if (ubicacionLaboralSelect.value === 'Home Office') {
            // Si se selecciona "Home Office", habilita los campos
            anydeskInput.removeAttribute('disabled');
            proveedorInternetInput.removeAttribute('disabled');
        } else {
            // De lo contrario, deshabilita los campos y limpia sus valores
            anydeskInput.setAttribute('disabled', 'true');
            proveedorInternetInput.setAttribute('disabled', 'true');
            anydeskInput.value = '';
            proveedorInternetInput.value = '';
        }
    });
});


