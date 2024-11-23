import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/index.css';

window.onload = function() {
    const apiSearch = document.querySelector('.api-search button');
    apiSearch.addEventListener('click', async function() {
        const search = this.parentElement.querySelector('input').value;
        if (search.length > 0) {
            const req = await fetch(`/api/libros?search=${search}`);
            const data = await req.json();
            console.log(data);
        }
    });
};