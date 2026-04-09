function openTicketModal() {
    document.getElementById('ticketModal').style.display = 'block';
}

function closeTicketModal() {
    document.getElementById('ticketModal').style.display = 'none';
}


document.addEventListener("DOMContentLoaded", function() {
    const successToast = document.getElementById('toast-success');
    
    if (successToast) {
        
        successToast.classList.add('show');
        setTimeout(() => {
            successToast.classList.remove('show');
        }, 3000);
    }
});




