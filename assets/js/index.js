import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/index.css';
// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

function populateModal(data) {
    const modalBody = document.querySelector('.modal-body .list-group');
    modalBody.innerHTML = '<p class="text-center">Selecciona un libro para añadir a la colección</p>';
    data.forEach((libro) => {
        const item = document.createElement('a');
        item.classList.add('list-group-item', 'list-group-item-action');
        item.dataset.titulo = libro.titulo;
        item.dataset.autor = libro.autor;
        item.dataset.isbn = libro.isbn;
        item.dataset.descripcion = libro.descripcion;
        const descr = libro.descripcion.length > 50 ? libro.descripcion.slice(0, 50) + '...' : libro.descripcion;
        item.href = `#`;
        item.innerHTML = `
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">${libro.titulo}</h5>
                <small>${libro.autor}</small>
            </div>
            <p class="mb-1">${descr}</p>
            <small>ISBN: ${libro.isbn}</small>
        `;
        modalBody.appendChild(item);
    });
}

function popup(message, type) {
    const toast = document.querySelector('.toast');
    toast.classList.remove('bg-danger', 'bg-success', 'bg-warning', 'bg-info');
    toast.classList.add(`bg-${type}`);
    toast.querySelector('.toast-body').innerText = message;
    new bootstrap.Toast().show();
}

async function agregarLibro(datos) {
    const formData = new FormData();
    formData.append('titulo', datos.titulo);
    formData.append('autor', datos.autor);
    formData.append('isbn', datos.isbn);
    formData.append('descripcion', datos.descripcion);

    const req = await fetch('/libros?format=json', {
        method: 'POST',
        body: formData,
    });
    const res = await req.json();
    if (res.error) {
        popup(res.error, 'danger');
    }
    if (res.id !== undefined) {
        window.location.reload();
    }
}

window.onload = function() {
    const apiSearch = document.querySelector('.api-search button');
    const modalElement = document.querySelector('#modal');
    const modal = new bootstrap.Modal(modalElement, {
        show: false,
    })
    modalElement.addEventListener('click', function(e) {
        const listItem = e.target.closest('.list-group-item');
        if (listItem) {
            const datos = {
                titulo: listItem.dataset.titulo,
                autor: listItem.dataset.autor,
                isbn: listItem.dataset.isbn,
                descripcion: listItem.dataset.descripcion,
            };
            agregarLibro(datos);
        }
    });
    apiSearch.addEventListener('click', async function() {
        const search = this.parentElement.querySelector('input').value;
        if (search.length > 0) {
            const req = await fetch(`/api/libros?search=${search}`);
            const data = await req.json();
            console.log(data);
            populateModal(data);
            modal.show();
        }
    });
};