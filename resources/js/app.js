import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('DOMContentLoaded', function () {
    const categoriesLink = document.getElementById('categories-link');
    const categoriesMenu = document.getElementById('categories-menu');

    categoriesLink.addEventListener('click', function (event) {
        event.preventDefault();
        
        if (categoriesMenu.innerHTML === '') {
            fetchCategories();
        } else {
            categoriesMenu.classList.toggle('show');
        }
    });

    function fetchCategories() {
        fetch('/categories')
            .then(response => response.json())
            .then(data => {
                categoriesMenu.innerHTML = createCategoriesList(data);
                categoriesMenu.classList.add('show');
            });
    }

    function createCategoriesList(categories) {
        let html = '<ul>';
        categories.forEach(category => {
            html += `<li>
                        <a href="#" data-id="${category.id}" class="category-link">${category.name}</a>
                        ${category.children.length > 0 ? `<ul class="subcategories" data-parent="${category.id}">
                            ${category.children.map(child => `<li><a href="#" data-id="${child.id}" class="category-link">${child.name}</a></li>`).join('')}
                        </ul>` : ''}
                    </li>`;
        });
        html += '</ul>';
        return html;
    }

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('category-link')) {
            event.preventDefault();
            const id = event.target.dataset.id;
            const subcategories = document.querySelector(`.subcategories[data-parent="${id}"]`);
            if (subcategories) {
                subcategories.classList.toggle('show');
            }
        }
    });
});
