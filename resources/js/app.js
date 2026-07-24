// toast
const toastElList = [].slice.call(document.querySelectorAll('.toast-session-values'))
const toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl) // No need for options; use the default options
});
toastList.forEach(toast => toast.show()); // This show them

// tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
