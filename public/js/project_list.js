document.addEventListener("DOMContentLoaded", function() {
    
    const modal = document.getElementById("projectModal");
    const btn = document.getElementById("openModalBtn");
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
    }


    // ==========================================
    // 2. GESTION DU FORMULAIRE API (AJAX)
    // ==========================================
    const form = document.getElementById('api-project-form');
    const tableBody = document.querySelector('.project-table tbody') || document.querySelector('table tbody');

    if(form) {
        form.addEventListener('submit', function(event) {
            // 2.1 On bloque le rechargement de la page
            event.preventDefault();

            // 2.2 On aspire toutes les données du formulaire (y compris le user_id caché)
            const formData = new FormData(form);

            // 2.3 On appelle notre API !
            fetch(form.action, {
                method: form.method,
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
                // 2.4 Si ça a marché, on affiche un petit message
                //alert(data.message); 

                // 2.5 AFFICHAGE DYNAMIQUE : On crée la nouvelle ligne <tr>
                const newRow = document.createElement('tr');
                
                // Clone EXACT de ton design Blade pour que la ligne soit parfaite
                newRow.innerHTML = `
                    <td>${data.project.ProjectName}</td>
                    <td>
                        <span style="font-weight: 600; color: #2D5BFF;">
                            ${data.project.Client || ''}
                        </span>
                    </td>
                    <td><p>${data.project.Description || ''}</p></td>
                    <td>
                        ${data.project.Collaborateur || ''}
                    </td>
                    <td class="center"> 
                        <a href="${data.project.show_url}" class="project-open_btn">Open</a>
                    </td>
                    <td class="center"> 
                        <form action="${data.project.destroy_url}" method="POST" class="api-delete-project">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="project-remove_btn">Remove</button>
                        </form>
                    </td>
                `;

                // 2.6 On ajoute la ligne tout en bas du tableau
                tableBody.append(newRow);

                // 2.7 On nettoie tout : on vide le formulaire et on cache la modale
                form.reset();
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
    if (event.target && event.target.classList.contains('api-delete-project')) {
        
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



