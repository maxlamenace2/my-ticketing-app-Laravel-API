
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

    const datesT = document.querySelector('.ticket-detail-section-dates .value');

    if(updateForm) {
        updateForm.addEventListener('submit', async function(event) {
            event.preventDefault(); 

            const data = {
                "title": updateForm.querySelector('input[name="title"]').value,
                "status": updateForm.querySelector('select[name="status"]').value,
                "priority": updateForm.querySelector('select[name="priority"]').value,
                "billing_type": updateForm.querySelector('select[name="billing_type"]').value,
                "time_spent":updateForm.querySelector('input[name="time_spent"]').value,
                "start_date":updateForm.querySelector('input[name="start_date"]').value,
                "end_date":updateForm.querySelector('input[name="end_date"]').value,
                "description":updateForm.querySelector('textarea[name="description"]').value,
                "assigned_to":updateForm.querySelector('input[name="assigned_to"]').value,
            };

            const formData = JSON.stringify(data)

            const csrfToken = updateForm.querySelector('input[name="_token"]').value;

            const id = updateForm.getAttribute("ticket-id");

            const response = await fetch(`/api/tickets/${id}`, {
                method: 'PUT', 
                headers: {
                    'Accept': 'application/json',
                    "Content-Type": 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })

            if (!response.ok) {
                const errorData = await response.json();
                console.error("Détail de l'erreur Laravel:", errorData);
                throw new Error(errorData.message || "Erreur lors de la création");
            }
            const message = await response.json();
        

        
            titreT.innerText = message.ticket.title || '';
            statusT.innerText = message.ticket.status || '';
            priorityT.innerText = message.ticket.priority || '';
            billing_typeT.innerText = message.ticket.billing_type  || '';
            time_spentT.innerText = message.ticket.time_spent || '';
            descriptionT.innerText = message.ticket.description || '';
            collaboratorT.innerText = message.ticket.assigned_to || '';

            if (datesT) {
                let start = message.ticket.start_date ? message.ticket.start_date.split('-').reverse().join('/') : 'N/A';
                let end = message.ticket.end_date ? message.ticket.end_date.split('-').reverse().join('/') : 'N/A';
                datesT.innerText = `Début : ${start} | Fin : ${end}`;
            }

            closeEditModal();

            toastUpdateSuccess.classList.add('show');
            toastUpdateSuccess.innerText = message.message; 

            setTimeout(() => {
                toastUpdateSuccess.classList.remove('show');
            }, 3000);  
        });
    }
});



