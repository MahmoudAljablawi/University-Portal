/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
*/

const html = document.documentElement;

const savedTheme = localStorage.getItem('theme');

if (savedTheme === 'dark' || savedTheme === 'light') {
    html.dataset.theme = savedTheme;
} else {
    html.dataset.theme = 'light';
}


/*
|--------------------------------------------------------------------------
| Application Initialization
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Theme Toggle
    |--------------------------------------------------------------------------
    */

    const themeButton = document.querySelector('[data-theme-toggle]');

    if (themeButton) {
        themeButton.addEventListener('click', () => {

            const currentTheme = html.dataset.theme;

            const newTheme =
                currentTheme === 'dark'
                    ? 'light'
                    : 'dark';

            html.dataset.theme = newTheme;

            localStorage.setItem('theme', newTheme);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Mobile Sidebar
    |--------------------------------------------------------------------------
    */

    const menuButton = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    const overlay = document.querySelector('[data-sidebar-overlay]');
    const closeButton = document.querySelector('[data-sidebar-close]');

    if (!menuButton || !sidebar || !overlay) {
        return;
    }


    const openSidebar = () => {
        sidebar.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');
    };


    const closeSidebar = () => {
        sidebar.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    };


    menuButton.addEventListener('click', openSidebar);

    overlay.addEventListener('click', closeSidebar);

    closeButton?.addEventListener('click', closeSidebar);


    /*
    |--------------------------------------------------------------------------
    | Escape Key
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', (event) => {

        if (event.key === 'Escape') {
            closeSidebar();
        }

    });

});

