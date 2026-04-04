
function openProjectEditModal() {
    document.getElementById('ProjetModal').style.display = 'block';
}
function closeProjectEditModal() {
    document.getElementById('ProjetModal').style.display = 'none';
}

function openTicketModal() {
    document.getElementById('ticketModal').style.display = 'block';
}
function closeTicketModal() {
    document.getElementById('ticketModal').style.display = 'none';
}



document.addEventListener('DOMContentLoaded', function() {
    
    const updateProjectForm = document.getElementById('api-update-project-form');
    const toastUpdateSuccess = document.getElementById('update-project-toats-success');

    const titleElement = document.querySelector('.my-project-info-container-1-name h1.editable');
    const descElement = document.querySelector('.my-project-info-container-1-details p.editable');
    const collabElement = document.querySelector('.cololaborators-list');
    const hoursElement = document.querySelector('.my-project-info-container-1-hours h1.editable');

    if(updateProjectForm) {
        updateProjectForm.addEventListener('submit', function(event) {
            event.preventDefault(); 
            const formData = new FormData(updateProjectForm);

            fetch(updateProjectForm.action, {
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
                closeProjectEditModal();

                // 5. ON AFFICHE LE TOAST DE SUCCÈS
                toastUpdateSuccess.classList.add('show');
                toastUpdateSuccess.innerText = data.message; 
        
                setTimeout(() => {
                    toastUpdateSuccess.classList.remove('show');
                }, 3000);

                
                titleElement.innerText = data.project.ProjectName || '';
                descElement.innerText = data.project.Description ||'';

                collabElement.innerText = data.project.Collaborateur || '';

                hoursElement.innerText = `${data.project.spent_hours}/${data.project.allocated_hours}h` || '';
            })
            .catch(error => {
                console.error('Erreur API :', error);
                alert("Erreur lors de la mise à jour : " + error.message);
            });
        });
    }
});


// ==========================================
// GESTION DE L'API (CRÉATION TICKET SANS RECHARGEMENT)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    
    const createTicketForm = document.getElementById('tickets_create_form');
    const ticketTableBody = document.querySelector('.ticket-table tbody');

    if(createTicketForm) {
        createTicketForm.addEventListener('submit', function(event) {
            
            // 1. On bloque le rechargement
            event.preventDefault(); 
            
            const formData = new FormData(createTicketForm);

            // 2. On envoie les données à l'API universelle des tickets
            fetch(createTicketForm.action, {
                method: 'POST', 
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || "Erreur lors de la création");
                }
                return response.json();
            })
            .then(data => {
                // 3. Succès : On ferme la modale et on vide le formulaire
                closeTicketModal();
                createTicketForm.reset();

                // 4. Si le tableau affichait "Aucun ticket", on enlève cette phrase
                const emptyMessage = ticketTableBody.querySelector('td[colspan="7"]');
                if (emptyMessage) {
                    emptyMessage.parentElement.remove();
                }

                // 5. On crée le HTML de la nouvelle ligne
                const newRow = document.createElement('tr');
                const priorityCapitalized = data.ticket.priority ? data.ticket.priority.charAt(0).toUpperCase() + data.ticket.priority.slice(1) : '';
                
                newRow.innerHTML = `
                    <td>${data.ticket.title}</td>
                    <td>${data.ticket.description || ''}</td>
                    <td>
                        <span style="font-weight: bold; color: #2D5BFF;">${data.ticket.status}</span>
                    </td>
                    <td class="status">${priorityCapitalized}</td>
                    <td>${data.ticket.assigned_to || 'Non assigné'}</td>
                    <td>
                        <a href="${data.ticket.show_url}">
                            <button class="project-open_btn">Open</button>
                        </a>
                    </td>
                    <td>
                        <form action="${data.ticket.destroy_url}" method="POST" class="api-delete-ticket">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="project-remove_btn">Remove</button>
                        </form>
                    </td>
                `;

                // 6. On l'ajoute tout en haut de la liste !
                ticketTableBody.prepend(newRow);
            })
            .catch(error => {
                console.error('Erreur API :', error);
                alert("Erreur : " + error.message);
            });
        });
    }
});
