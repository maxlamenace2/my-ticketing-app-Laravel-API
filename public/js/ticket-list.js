
document.addEventListener("DOMContentLoaded", function() {

    const modal = document.getElementById("ticketModal");
    const btn = document.getElementById("openTicketModalBtn");
    const span = document.getElementsByClassName("close-btn")[0];

    if (btn && modal && span) {   
        btn.onclick = function(event) {
            event.preventDefault(); 
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }   
    } else {
        console.error("Erreur : Le modal, le bouton d'ouverture ou la croix de fermeture est introuvable.");
    }




    // ==========================================
    // 2. GESTION DU FORMULAIRE API (AJAX)
    // ==========================================
    const formTicket = document.getElementById('api-ticket-form');

    const tableBody = document.querySelector('.ticket-table-list tbody') || document.querySelector('table tbody');

    if(formTicket) {
        formTicket.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(formTicket);

            // On utilise la super astuce du prof (action et method)
            fetch(formTicket.action, {
                method: formTicket.method,
                headers: {
                    'Accept': 'application/json'
                    // Pas besoin de CSRF ici si tu as bien mis @csrf dans ton <form>
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    console.error("Détail de l'erreur Laravel:", errorData);
                    throw new Error(errorData.message || "Erreur lors de la création");
                }
                return response.json();
            })
            .then(data => {
                // AFFICHAGE DYNAMIQUE : On crée la nouvelle ligne <tr>
                const newRow = document.createElement('tr');
                
                // Clone EXACT de ton design Blade pour les TICKETS
                // On utilise data.ticket.xxx (et non data.project)
                newRow.innerHTML = `
                    <td>${data.ticket.projectName}</td>
                    <td>${data.ticket.title}</td>
                    <td>${data.ticket.status}</td>
                    <td class="status">${data.ticket.priority || ''}</td>
                    <td>${data.ticket.assigned_to || ''}</td>
                    <td>
                        <a href="${data.ticket.show_url}">
                            <button class="ticket-open_btn">Open</button>
                        </a>
                    </td>
                    <td>
                        <form action="${data.ticket.destroy_url}" method="POST" class="api-delete-ticket">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="ticket-remove_btn">Remove</button>
                        </form>
                    </td>
                `;

                // On ajoute la ligne tout en haut du tableau (prepend c'est mieux que append pour voir le nouveau ticket tout de suite !)
                tableBody.append(newRow);

                // On nettoie tout
                formTicket.reset();
                if(modal) {
                    modal.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Erreur API :', error);
                alert("Une erreur s'est produite. Vérifiez que tous les champs requis sont remplis.");
            });
        });
    }

});



document.addEventListener('submit', function(event) {
    // On vérifie si le formulaire soumis a bien notre classe spéciale
    if (event.target && event.target.classList.contains('api-delete-ticket')) {
        
        // 1. On bloque le rechargement
        event.preventDefault();
        
        // 2. On demande confirmation
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            return; 
        }

        const form = event.target;
        const row = form.closest('tr'); 
        
        // LA MAGIE EST ICI : On va chercher la valeur du @csrf directement dans le formulaire cliqué !
        const csrfToken = form.querySelector('input[name="_token"]').value;

        // 3. On envoie la requête DELETE à l'API
        fetch(form.action, {
            method: 'DELETE', 
            headers: {
                'X-CSRF-TOKEN': csrfToken, // On envoie le jeton qu'on vient de récupérer
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if(response.ok) {
                // 4. L'ANIMATION : La ligne devient transparente puis disparaît !
                row.classList.add('fade-out-row');
                
                setTimeout(() => {
                    row.remove();
                }, 500);
                
            } else {
                alert("Erreur lors de la suppression. Vous n'avez peut-être pas les droits.");
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});




// On veut gérer les filtres
// je selectionne tous les filtres
/*const filtres_priority = document.querySelectorAll(".btn-filtre-priority");

for (let i= 0; i < filtres_priority.length; i++) {
    filtres_priority[i].addEventListener("click", function(event) {
        event.preventDefault();
        
        console.log(filtres_priority[i].innerText);

        const trs = document.querySelectorAll('#content tbody tr');

        // Je veux parcourir mon tableau
        for (let j=0; j < trs.length ; j++) {
            console.log(trs[j]);
            const status = trs[j].querySelector(".status");
            
            console.log(status.innerText);

            
            if (filtres_priority[i].innerText.toLowerCase() != "all")
            {
                if (filtres_priority[i].innerText.toLowerCase() != status.innerText.toLowerCase()) {
                // On cache toute la ligne (= le tr)
                    trs[j].classList.add('hidden');
                } else {
                    trs[j].classList.remove('hidden');
                }
            } else {
                trs[j].classList.remove('hidden');
            }
            

        }

    });

}*/


/*
function check_id() {
    // On veut vérifier les champs du formulaire
    const id = document.querySelector('#ticketId');
    // .value récupère la valeur d'un input
    console.log("id : ", id.value);

    const ticket_id_error_void = document.querySelector('#ticket-id-error-void');
    const ticket_id_error_number = document.querySelector('#ticket-id-error-number');
    if(id.value == "") {
        ticket_id_error_void.classList.remove('hidden');
        return 1;
    } else {
        ticket_id_error_void.classList.add('hidden');
        // ^ = debut de chaine d = digit $ = fin de chaine
        if (!(/^\d+$/.test(id.value))) {
            console.log("Il y a pas que des chiffres");
            ticket_id_error_number.classList.remove('hidden');
            return 1;
        } else {
            console.log("il y a que des chiffres");
            ticket_id_error_number.classList.add('hidden');
            return 0;
        }
    }
}


function check_name() {
    console.log('on fait le check name');

    const name = document.querySelector('#ticketName');
    // .value récupère la valeur d'un input
    console.log("name : ", name.value);

    const ticket_name_error_void = document.querySelector('#ticket-name-error-void');
    if(name.value == "") {
        ticket_name_error_void.classList.remove('hidden');
        return 1;
    } else {
        ticket_name_error_void.classList.add('hidden');
        return 0;
    }
}

function check_time() {
    console.log('on fait le check time');

    const time = document.querySelector('#ticketTime');
    // .value récupère la valeur d'un input
    console.log("time : ", time.value);

    const ticket_time_error_void = document.querySelector('#ticket-time-error-void');
    const ticket_time_error_format = document.querySelector('#ticket-time-error-format');
    if(time.value == "") {
        ticket_time_error_void.classList.remove('hidden');
        return 1;
    } else {
        ticket_time_error_void.classList.add('hidden'); 


        const regexFormat = /^\d+h \d+m$/;//!!!!!!!!!!!!!!!!!!!
        if (regexFormat.test(time.value) == false) {
            ticket_time_error_format.classList.remove('hidden');
            console.log("here");
            return 1;
        }
        else {
            ticket_time_error_format.classList.add('hidden');
            return 0;
        }
    } 
}

function check_Description() {

    const description = document.querySelector('#ticket-details');
    // .value récupère la valeur d'un input
    console.log("description : ", description.value);

    const ticket_description_error_void = document.querySelector('#ticket-description-error-void');
    if(description.value == "") {
        ticket_description_error_void.classList.remove('hidden');
        return 1;
    } else {
        ticket_description_error_void.classList.add('hidden');
        return 0;
    }
}

function check_collaborators() {
    const collaborators = document.querySelector('#ticketCollaborator');
    
    const ticket_collaborators_error_void = document.querySelector('#ticket-collaborator-error-void');
    const ticket_collaborator_error_format = document.querySelector('#ticket-collaborator-error-format');
    if(collaborators.value == "") {
        ticket_collaborators_error_void.classList.remove('hidden');
        return 1;
    } else {
        ticket_collaborators_error_void.classList.add('hidden');
        
        // Regex explicative :
        // ^                    : Début
        // [a-zA-ZÀ-ÿ\s-]+      : Un nom (Lettres, Accents, Espaces, Tirets)
        // (,\s*[a-zA-ZÀ-ÿ\s-]+)* : Un groupe répété (Virgule + Espace optionnel + Autre nom)
        // $                    : Fin
        const regexFormat = /^[a-zA-ZÀ-ÿ\s-]+(,\s*[a-zA-ZÀ-ÿ\s-]+)*$/;
        if (regexFormat.test(collaborators.value) == false) {
            ticket_collaborator_error_format.classList.remove('hidden');
            console.log("hello");
            return 1;
        }
        else {
            ticket_collaborator_error_format.classList.add('hidden');
            return 0;
        }
    }
}





// sélection du form #submitform
const Ticketform = document.querySelector('#tickets_create_form');


// je crée un écouteur d'événement pour gérer la soumission du form
Ticketform.addEventListener("submit", function(event) {
    // on empeche la soumission du formulaire
    // pour éviter le rechargement de page
    event.preventDefault();
    console.log('j\'ai soumis mon formulaire');

    
    let nb_errors = 0;
    nb_errors += check_id();

    console.log('chck id fait');
    nb_errors += check_name();

    nb_errors += check_time();

    nb_errors += check_Description();

    nb_errors += check_collaborators();
    
    
    if(nb_errors == 0) {
        // Je vais ajouter la ligne dans mon tableau
        const a = document.querySelector('#ticketId');
        const b = document.querySelector('#ticketName');
        const c = document.querySelector('#ticketTime');
        const d = document.querySelector('#ticket-details');
        const e = document.querySelector('#ticketCollaborator');

    
        // Je vide le formulaire
        a.value = "";
        b.value = "";
        c.value = "";
        d.value = "";
        e.value = "";

        // J'affiche le "toast"
        const toast = document.querySelector("#success");
        console.log("fichier crer");
        toast.classList.remove('hidden');
        // J'attends 3 secondes, puis je l'enlève : 
        setTimeout(() => {
            toast.classList.add('hidden');
            console.log("fichier crer hidden");
        }, 5000);
    }
});
*/

