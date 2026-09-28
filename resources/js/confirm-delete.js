/**
 * Delete confirmation for multiple forms with same selector
 */
export function deleteConfirm(formSelector, itemName = 'this item') {
    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll(formSelector);

        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    html: `<p class="text-sm">You are about to delete <strong>${itemName}</strong>.</p>
                           <p class="text-xs text-gray-500 mt-2">This action cannot be undone.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition',
                        cancelButton: 'px-4 py-2 bg-gray-400 text-white rounded-lg font-medium hover:bg-gray-500 transition ms-2',
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        form.submit();
                    }
                });
            });
        });
    });
}

/**
 * Simple usage for single form by ID
 */
export function deleteConfirmSingle(formId, itemName = 'this item') {
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById(formId);
        
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    html: `<p class="text-sm">You are about to delete <strong>${itemName}</strong>.</p>
                           <p class="text-xs text-gray-500 mt-2">This action cannot be undone.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition',
                        cancelButton: 'px-4 py-2 bg-gray-400 text-white rounded-lg font-medium hover:bg-gray-500 transition ms-2',
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        form.submit();
                    }
                });
            });
        }
    });
}