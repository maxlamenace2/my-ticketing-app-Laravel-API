document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('error')) {
        const toast = document.getElementById('error-toast');
        
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
            window.history.replaceState({}, document.title, window.location.pathname);
        }, 3500);
    }
});