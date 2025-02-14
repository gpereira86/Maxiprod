document.addEventListener('click', function (event) {
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const dropdownButton = document.querySelector('.navbar-toggler');

    if (!navbarCollapse.contains(event.target) && !dropdownButton.contains(event.target)) {
        navbarCollapse.classList.remove('show');
    }
});

document.querySelector('.navbar-collapse').addEventListener('click', function (event) {
    event.stopPropagation();
});