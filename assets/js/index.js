import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/index.css';

window.onload = function() {
    const buttons = document.querySelectorAll('main button');
    const apiSearch = document.querySelector('.api-search button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.parentElement.parentElement.getAttribute('data-id');
            const action = this.classList.contains('delete') ? 'eliminar' : 'editar';
            window.location.href = `/libros/${id}/${action}`;
        });
    });
    apiSearch.addEventListener('click', async function() {
        const search = this.parentElement.querySelector('input').value;
        const req = await fetch(`/api/libros?search=${search}`);
        const data = await req.json();
    });
};