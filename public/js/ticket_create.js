document.addEventListener("DOMContentLoaded", function() {

    // ==========================================
    // GESTION DE LA POP-UP (MODAL)
    // ==========================================
    
    // 1. Récupération des éléments HTML par leur ID ou Classe
    const modal = document.getElementById("ticketModal");
    const btn = document.getElementById("openTicketModalBtn");
    const span = document.getElementsByClassName("close-btn")[0];

    // 2. Vérification de sécurité (pour éviter les erreurs console si un élément manque)
    if (btn && modal && span) {
        
        // A. Ouvrir la fenêtre au clic sur le bouton "New Ticket"
        btn.onclick = function(event) {
            event.preventDefault(); // Empêche le lien de recharger la page ou de remonter
            modal.style.display = "block";
        }

        // B. Fermer la fenêtre au clic sur la croix (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // C. Fermer la fenêtre au clic en dehors du formulaire (sur le fond gris)
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
    } else {
        console.error("Erreur : Le modal, le bouton d'ouverture ou la croix de fermeture est introuvable.");
    }

});



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


