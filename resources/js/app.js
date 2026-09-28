/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
*/
import Swal from "sweetalert2";
import { deleteConfirm, deleteConfirmSingle } from "./confirm-delete.js";

window.Swal = Swal;
window.deleteConfirm = deleteConfirm;
window.deleteConfirmSingle = deleteConfirmSingle;

const html = document.documentElement;

const savedTheme = localStorage.getItem("theme");

if (savedTheme === "dark" || savedTheme === "light") {
    html.dataset.theme = savedTheme;
} else {
    html.dataset.theme = "light";
}

/*
|--------------------------------------------------------------------------
| Application Initialization
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Delete Confirmation Handler
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-form');
    
    deleteButtons.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const itemName = this.getAttribute('data-item-name') || 'item';
            const confirmText = this.getAttribute('data-confirm-text') || 'Delete?';
            
            Swal.fire({
                title: confirmText,
                text: itemName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                width: '320px',
                padding: '1.25rem',
                backdrop: 'rgba(0, 0, 0, 0.3)',
                customClass: {
                    popup: 'rounded-lg shadow-xl border border-gray-200',
                    title: 'text-base font-semibold text-gray-900',
                    htmlContainer: 'text-sm text-gray-600 mt-2',
                    confirmButton: 'px-4 py-2 bg-red-600 text-white rounded-md font-medium text-sm hover:bg-red-700',
                    cancelButton: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-md font-medium text-sm hover:bg-gray-300',
                },
                didOpen: () => {
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    form.submit();
                }
            });
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Theme Toggle
    |--------------------------------------------------------------------------
    */

    const themeButton = document.querySelector("[data-theme-toggle]");

    if (themeButton) {
        themeButton.addEventListener("click", () => {
            const currentTheme = html.dataset.theme;

            const newTheme = currentTheme === "dark" ? "light" : "dark";

            html.dataset.theme = newTheme;

            localStorage.setItem("theme", newTheme);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile Sidebar
    |--------------------------------------------------------------------------
    */

    const menuButton = document.querySelector("[data-sidebar-toggle]");
    const sidebar = document.querySelector("[data-sidebar]");
    const overlay = document.querySelector("[data-sidebar-overlay]");
    const closeButton = document.querySelector("[data-sidebar-close]");

    if (!menuButton || !sidebar || !overlay) {
        return;
    }

    const openSidebar = () => {
        sidebar.classList.remove("hidden");

        document.body.classList.add("overflow-hidden");
    };

    const closeSidebar = () => {
        sidebar.classList.add("hidden");

        document.body.classList.remove("overflow-hidden");
    };

    menuButton.addEventListener("click", openSidebar);

    overlay.addEventListener("click", closeSidebar);

    closeButton?.addEventListener("click", closeSidebar);

    /*
    |--------------------------------------------------------------------------
    | Escape Key
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeSidebar();
        }
    });
});
