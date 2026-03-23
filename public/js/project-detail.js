

/*document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.edit-btn').forEach(btn => {
        
    
        btn.addEventListener('click', function() {
            
            
            const content = this.parentElement.querySelector('.editable');
            
            // Si on ne trouve rien (sécurité), on arrête
            if (!content) return;

            
            if (content.isContentEditable) {
                // SAUVEGARDE
                content.contentEditable = "false";
                this.innerText = "EDIT";
                content.style.border = "none";
                
            } else {
                // ÉDITION
                content.contentEditable = "true";
                content.focus();
                this.innerText = "SAVE";
                content.style.border = "1px dashed #ccc";
            }
        });
    });


    //COLAB 

    const collabBtn = document.querySelector('.edit-collab-btn');

    collabBtn.addEventListener('click', function() {
        const container = this.parentElement.querySelector('.collab-container'); 
        
        if (container.isContentEditable) {
            // Sauvegarder
            container.contentEditable = "false";
            this.innerText = "EDIT";
            container.style.border = "none";
            
        } else {
            // Éditer
            container.contentEditable = "true";
            container.focus();
            this.innerText = "SAVE";
            container.style.border = "1px dashed #ccc"; 
        }
    });


*/



    




























    

document.addEventListener('DOMContentLoaded', () => {

    const uploadBtn = document.getElementById('btn-upload');
    const downloadBtn = document.getElementById('btn-download');
    const realInput = document.getElementById('real-file-input');
    const fileNameDisplay = document.getElementById('file-name-display');

    let currentFileUrl = null; 

    
    uploadBtn.addEventListener('click', function() {
        
        realInput.click();
        console.log("HERE5");
    });

   
    realInput.addEventListener('change', function(e) {
        console.log("HERE6");
        if (this.files && this.files[0]) {
            const myFile = this.files[0];

            
            fileNameDisplay.innerText = "Fichier : " + myFile.name;

       
            if (currentFileUrl) {
                URL.revokeObjectURL(currentFileUrl); 
            }
            currentFileUrl = URL.createObjectURL(myFile);

            
            downloadBtn.disabled = false;
            
        }
    });

    // 4. Quand on clique sur "Download"
    downloadBtn.addEventListener('click', function() {
        if (currentFileUrl) {
            console.log("HERE7");
            
            const link = document.createElement('a');
            link.href = currentFileUrl;
            
            
            link.download = realInput.files[0].name; 
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else {
            alert("Aucun contrat n'a été uploadé !");
        }
    });
});


/*
//FILTRE
const filtres_priority = document.querySelectorAll(".btn-filtre-priority");

for (let i= 0; i < filtres_priority.length; i++) {
    filtres_priority[i].addEventListener("click", function(event) {
        event.preventDefault();
        // Texte du bouton
        console.log(filtres_priority[i].innerText);

        const trs = document.querySelectorAll('#content tbody tr');

        // Je veux parcourir mon tableau
        for (let j=0; j < trs.length ; j++) {
            console.log(trs[j]);
            const status = trs[j].querySelector(".status");
            // texte de la case dans le tableau
            console.log(status.innerText);

            // Je veux comparer mon texte du bouton, avec celui de la case du tableau
            // Si le texte est différent, on cache la ligne
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






/*function check_name() {
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




document.addEventListener("DOMContentLoaded", function() {

    // ==========================================
    // GESTION DE LA POP-UP (MODAL)
    // ==========================================
    
    console.log("HERE");
    const modal = document.getElementById("ticketModal");
    const btn = document.getElementById("openTicketModalBtn");
    const span = document.getElementsByClassName("close-btn-ticket")[0];
    console.log("HERE");

    // 2. Vérification de sécurité (pour éviter les erreurs console si un élément manque)
    if (btn && modal && span) {
        console.log("HERE");
        btn.onclick = function(event) {
            event.preventDefault();
            modal.style.display = "block";
            console.log("HERE4");
        }

        span.onclick = function() {
            modal.style.display = "none";
            console.log("HERE5");
        }

        
        /*window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                console.log("HERE6");
            }
        }*/
        
    } else {
        console.error("Erreur : Le modal, le bouton d'ouverture ou la croix de fermeture est introuvable.");
    }


    const modal0 = document.getElementById("ProjetModal");
    const btn0 = document.getElementById("openProjectModalBtn");
    const span0 = document.getElementsByClassName("Project-modale-close-btn")[0];





    if (btn0 && modal0 && span0) {
        console.log("HERE");
        btn0.onclick = function(event) {
            event.preventDefault();
            modal0.style.display = "block";
            console.log("HERE4");
        }

        span0.onclick = function() {
            modal0.style.display = "none";
            console.log("HERE5");
        }

        
        /*window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                console.log("HERE6");
            }
        }*/
        
    } else {
        console.error("Erreur2 : Le modal, le bouton d'ouverture ou la croix de fermeture est introuvable.");
    }
});



