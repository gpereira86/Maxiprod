document.addEventListener('DOMContentLoaded', function () {
    const selectUsuario = document.querySelector('select[name="pessoa"]');
    const radioEntrada = document.querySelector('#option1');
    const radioSaida = document.querySelector('#option2');
    const labelEntrada = document.querySelector('label[for="option1"]');
    const labelSaida = document.querySelector('label[for="option2"]');
    const formElements = document.querySelectorAll('input:not([name="pessoa"]), textarea, select:not([name="pessoa"]), button');
    function toggleFormElements() {
        const isUserSelected = (selectUsuario.value !== '' && selectUsuario.value !== "-- Selecione a pessoa aqui --");
        const alertButton = document.querySelector('.alert .btn-close');
        const dropdownButton = document.getElementById('menuDropdownButton');

        formElements.forEach(element => {
            element.disabled = !isUserSelected;
        });

        if (alertButton) {
            alertButton.removeAttribute('disabled');
        }

        if (dropdownButton){
            dropdownButton.removeAttribute('disabled');
        }

        toggleRadioButtons(isUserSelected);
    }

    function toggleRadioButtons(isUserSelected) {
        const selectedOption = selectUsuario.selectedOptions[0];
        const userAge = selectedOption ? parseInt(selectedOption.getAttribute('age')) : null;


        if (!isUserSelected || userAge === null) {
            radioEntrada.disabled = true;
            radioSaida.disabled = true;
            return;
        }

        if (userAge < 18) {
            radioEntrada.disabled = true;
            labelEntrada.classList.remove('btn-outline-success');
            labelEntrada.classList.add('btn-secondary');
            radioSaida.checked = true;
        } else {
            radioEntrada.disabled = false;
            labelEntrada.classList.remove('btn-secondary');
            labelEntrada.classList.add('btn-outline-success');

            if (radioSaida.checked) {
                radioSaida.checked=true;
            } else {
                radioEntrada.checked=true
            }

        }

        radioSaida.disabled = false;
        labelSaida.classList.remove('btn-secondary');
        labelSaida.classList.add('btn-outline-danger');
    }

    toggleFormElements();

    selectUsuario.addEventListener('change', toggleFormElements);
});
