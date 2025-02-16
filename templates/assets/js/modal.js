document.addEventListener('DOMContentLoaded', function () {
    const deleteLinks = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteModal"]');
    const modalPersonName = document.getElementById('modalPersonName');
    const confirmDeleteLink = document.getElementById('confirmDelete');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function () {
            const personId = link.getAttribute('data-id');
            const personName = link.getAttribute('data-name');
            let deleteUrl = window.location.href.replace('/cadastrar-pessoa', '/deletar-pessoa/');

            modalPersonName.textContent = personName;
            confirmDeleteLink.setAttribute('href', deleteUrl + personId);
        });
    });
});

