import {getUserList} from './components/UserList.js';

const app = document.getElementById('app');
const views = {
    home: async () => {
        const res = await fetch('./src/views/home.html');
        app.innerHTML = await res.text();
    },
    user: async () => {
        const res = await fetch('./src/views/user.html');
        app.innerHTML = await res.text();
        await getUserList();
    },
    products: async () => {
        const res = await fetch('./src/views/products.html');
        app.innerHTML = await res.text();
    },
    inventory: async () => {
        const res = await fetch('./src/views/inventory.html');
        app.innerHTML = await res.text();
    },
    sales: async () => {
        const res = await fetch('./src/views/sales.html');
        app.innerHTML = await res.text();
    },
    clients: async () => {
        const res = await fetch('./src/views/clients.html');
        app.innerHTML = await res.text();
    },
    orders: async () => {
        const res = await fetch('./src/views/orders.html');
        app.innerHTML = await res.text();
    },
};

document.addEventListener('click', async (event) => {
    const link = event.target.closest('[data-view]');
    if (!link) {
        return;
    }

    event.preventDefault();
    const view = link.dataset.view;
    if (views[view]) {
        await views[view]();
        document.querySelectorAll('.nav-link').forEach(item => {
            item.classList.toggle('active', item.dataset.view === view);
        });
    }
});

views.home();