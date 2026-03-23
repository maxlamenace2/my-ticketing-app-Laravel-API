document.addEventListener("DOMContentLoaded", function() {
    
    // Récupération des éléments du DOM
    const modal = document.getElementById("projectModal");
    const btn = document.getElementById("openModalBtn");
    const span = document.getElementsByClassName("close-btn")[0];

    // Vérification que les éléments existent pour éviter les erreurs
    if (btn && modal && span) {
        
        // Ouvrir le modal au clic sur le bouton
        btn.onclick = function(event) {
            event.preventDefault(); // Empêche le lien de recharger la page
            modal.style.display = "block";
        }

        // Fermer le modal avec la croix
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Fermer le modal si on clique en dehors du contenu (sur le fond gris)
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
});

/*
function check_id() {
    const id = document.querySelector('#projectId');
    
    console.log("id : ", id.value);

    const project_id_error_void = document.querySelector('#project-id-error-void');
    const project_id_error_number = document.querySelector('#project-id-error-number');
    if(id.value == "") {
        project_id_error_void.classList.remove('hidden');
        return 1;
    } else {
        project_id_error_void.classList.add('hidden');
        // ^ = debut de chaine d = digit $ = fin de chaine
        if (!(/^\d+$/.test(id.value))) {
            console.log("Il y a pas que des chiffres");
            project_id_error_number.classList.remove('hidden');
            return 1;
        } else {
            console.log("il y a que des chiffres");
            project_id_error_number.classList.add('hidden');
            return 0;
        }
    }
}

function check_name() {
    console.log('on fait le check name');

    const name = document.querySelector('#projectName');
    
    console.log("name : ", name.value);

    const project_name_error_void = document.querySelector('#project-name-error-void');
    if(name.value == "") {
        project_name_error_void.classList.remove('hidden');
        return 1;
    } else {
        project_name_error_void.classList.add('hidden');
        return 0;
    }
}

function check_detail() {
    console.log('on fait le check detail');

    const detail = document.querySelector('#projectDetail');
    
    console.log("name : ", detail.value);

    const project_detail_error_void = document.querySelector('#project-detail-error-void');
    if(detail.value == "") {
        project_detail_error_void.classList.remove('hidden');
        return 1;
    } else {
        project_detail_error_void.classList.add('hidden');
        return 0;
    }
}

function check_collaborators() {
    console.log('on fait le check collaborator');

    const collaborators = document.querySelector('#projectCollaborators');
    
    console.log("name : ", collaborators.value);

    const project_collaborator_error_void = document.querySelector('#project-collaborators-error-void');
    if(collaborators.value == "") {
        project_collaborator_error_void.classList.remove('hidden');
        return 1;
    } else {
        project_collaborator_error_void.classList.add('hidden');
        return 0;
    }
}


const f = document.querySelector('#projects-create-form');



f.addEventListener("submit", function(event) {
    // on empeche la soumission du formulaire
    // pour éviter le rechargement de page
    event.preventDefault();
    console.log('j\'ai soumis mon formulaire');

    
    let nb_errors = 0;
    nb_errors += check_id();

    console.log('chck id fait');
    nb_errors += check_name();

    nb_errors += check_detail();

    nb_errors += check_collaborators();


    
    console.log("nb_errors : ", nb_errors);

    
    if(nb_errors == 0) {
        // Je vais ajouter la ligne dans mon tableau
        const a = document.querySelector('#projectId');
        const b = document.querySelector('#projectName');
        const c = document.querySelector('#projectDetail');
        const d = document.querySelector('#projectCollaborators');

    
        // Je vide le formulaire
        a.value = "";
        b.value = "";
        c.value = "";
        d.value = "";

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



