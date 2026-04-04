
function openEditModal() {
    document.getElementById('ticketEditModal').style.display = 'block';
}
function closeEditModal() {
    document.getElementById('ticketEditModal').style.display = 'none';
}


document.addEventListener('DOMContentLoaded', function() {
    
    const updateForm = document.getElementById('api-update-ticket-form');
    const toastUpdateSuccess = document.getElementById('update-success-msg');
    const titreT = document.querySelector('.ticket-detail-section-title .value');
    const statusT = document.querySelector('.ticket-detail-section-status .value');
    const priorityT = document.querySelector('.ticket-detail-section-priority .value');
    const billing_typeT= document.querySelector('.ticket-detail-section-billing-type .value');
    const time_spentT = document.querySelector('.ticket-detail-section-time-spent .value');
    const descriptionT = document.querySelector('.ticket-detail-section-description .value');
    const collaboratorT = document.querySelector('.ticket-detail-section-collaborators .collaborators-list .value');


    if(updateForm) {
        updateForm.addEventListener('submit', function(event) {
            event.preventDefault(); 

            const formData = new FormData(updateForm);

            fetch(updateForm.action, {
                method: 'POST', 
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || "Erreur de mise à jour");
                }
                return response.json();
            })
            .then(data => {
                titreT.innerText = data.ticket.title || '';
                statusT.innerText = data.ticket.status || '';
                priorityT.innerText = data.ticket.priority || '';
                billing_typeT.innerText = data.ticket.billing_type  || '';
                time_spentT.innerText = data.ticket.time_spent || '';
                descriptionT.innerText = data.ticket.description || '';
                collaboratorT.innerText = data.ticket.assigned_to || '';
                closeEditModal();

                toastUpdateSuccess.classList.add('show');
                toastUpdateSuccess.innerText = data.message; 

                setTimeout(() => {
                    toastUpdateSuccess.classList.remove('show');
                }, 3000);
            })
            .catch(error => {
                console.error('Erreur API :', error);
                alert("Erreur lors de la mise à jour : " + error.message);
            });
        });
    }
});



