function check_name() {
    console.log('on fait le check name');

    const name = document.querySelector('#InscriptionName');
    
    const inscription_name_error_void = document.querySelector('#inscription-name-error-void');
    const inscription_name_error_letter = document.querySelector('#inscription-name-error-letter');
    if(name.value == "") {
        inscription_name_error_void.classList.remove('hidden');
        return 1;
    } else {
        inscription_name_error_void.classList.add('hidden');
        
        if (name.value.length <= 2) {
            inscription_name_error_letter.classList.remove('hidden');
            return 1;
        }
        else {
            inscription_name_error_letter.classList.add('hidden');
            return 0;
        }
    }
}

function check_surname() {
        console.log('on fait le check surname');

    const surname = document.querySelector('#InscriptionSurname');
    
    const inscription_surname_error_void = document.querySelector('#inscription-surname-error-void');
    const inscription_surname_error_letter = document.querySelector('#inscription-surname-error-letter');
    if(surname.value == "") {
        inscription_surname_error_void.classList.remove('hidden');
        return 1;
    } else {
        inscription_surname_error_void.classList.add('hidden');
        
        if (surname.value.length <= 2) {
            inscription_surname_error_letter.classList.remove('hidden');
            return 1;
        }
        else {
            inscription_surname_error_letter.classList.add('hidden');
            return 0;
        }
    }
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function check_email() {
            
    
    const email = document.querySelector('#InscriptionEmail');
    
    const inscription_email_error_void = document.querySelector('#inscription-email-error-void');
    const inscription_email_error_letter = document.querySelector('#inscription-email-error-letter');
    const inscription_email_error_ars = document.querySelector('#inscription-email-error-ars');
    if(email.value == "") {
        inscription_email_error_void.classList.remove('hidden');
        return 1;
    } else {
        inscription_email_error_void.classList.add('hidden');
        
        if (email.value.length <= 2) {
            inscription_email_error_letter.classList.remove('hidden');
            return 1;
        }
        else {
            inscription_email_error_letter.classList.add('hidden');
            if (!validateEmail(email.value)) {
                inscription_email_error_ars.classList.remove('hidden');
                return 1;
            } else {
                inscription_email_error_ars.classList.add('hidden');
                return 0;
            }
        }
    }
}


function check_date() {

    const date = document.querySelector('#InscriptionDate');
    
    const inscription_date_error_void = document.querySelector('#inscription-date-error-void');
    const inscription_date_error_old = document.querySelector('#inscription-date-error-old');
    if(date.value == "") {
        inscription_date_error_void.classList.remove('hidden');
        return 1;
    } else {
        inscription_date_error_void.classList.add('hidden');
        
        const birthDate = new Date(date.value);
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();

        const m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--; 
        }

        if (age<15) {
            inscription_date_error_old.classList.remove('hidden');
            return 1;
        }
        else {
            inscription_date_error_old.classList.add('hidden'); 
            return 0;   
        }
        
    }
}

function check_mdp() {

    const mdp1 = document.querySelector('#InscriptionMdp1');
    const mdp2 = document.querySelector('#InscriptionMdp2');
    const inscription_mdp_error_void = document.querySelector('#inscription-mdp-error-void');
    const inscription_mdp_error_caractere = document.querySelector('#inscription-mdp-error-caractere');
    const inscription_mdp_error_void2 = document.querySelector('#inscription-mdp-error-void2');
    const inscription_mdp_error_caractere2 = document.querySelector('#inscription-mdp-error-caractere2');
    const inscription_mdp_error_same = document.querySelector('#inscription-mdp-error-same');
    let res = 0;
    if(mdp1.value == "") {
        inscription_mdp_error_void.classList.remove('hidden');
        res = 1;
    } else {
        inscription_mdp_error_void.classList.add('hidden');
        
        if (mdp1.value.length < 10) {
            inscription_mdp_error_caractere.classList.remove('hidden');
            res = 1;
        }
        else {
            inscription_mdp_error_caractere.classList.add('hidden');
            res = 0;
        }
    }

    if(mdp2.value == "") {
        inscription_mdp_error_void2.classList.remove('hidden');
        res = 1;
    } else {
        inscription_mdp_error_void2.classList.add('hidden');
        
        if (mdp2.value.length < 10) {
            inscription_mdp_error_caractere2.classList.remove('hidden');
            res = 1;
        }
        else {
            inscription_mdp_error_caractere2.classList.add('hidden');
            res = 0;
        }
    }

    if (!(mdp1.value == mdp2.value)) {
        inscription_mdp_error_same.classList.remove('hidden');
        res = 1;
    } else {
        inscription_mdp_error_same.classList.add('hidden');
        res = 0;
    }


    if (res == 0) {
        return 0;
    } 
    else {
        return 1;
    }
}

function check_box() {

    const checkbox = document.querySelector('#IncriptionCheckBox');
    
    const inscription_checkbox_error_void = document.querySelector('#inscription-checkbox-error-void');
    if(!checkbox.checked) {
        inscription_checkbox_error_void.classList.remove('hidden');
        return 1;
    } else {
        inscription_checkbox_error_void.classList.add('hidden');
        return 0;
    }
}






const inscription = document.querySelector('#projects-form');



inscription.addEventListener("submit", function(event) {

    event.preventDefault();
    console.log('j\'ai soumis mon formulaire');

    
    let nb_errors = 0;
    nb_errors = check_name();

    nb_errors = check_surname();

    nb_errors = check_email();

    nb_errors = check_date();

    nb_errors = check_mdp();

    nb_errors = check_box();
   

    

    if(nb_errors == 0) {
        // Je vais ajouter la ligne dans mon tableau
        const a = document.querySelector('#InscriptionName');
        const b = document.querySelector('#InscriptionSurname');
        const c = document.querySelector('#InscriptionEmail');
        const d = document.querySelector('#InscriptionDate');
        const e = document.querySelector('#InscriptionMdp1');
        const f = document.querySelector('#InscriptionMdp2');
        const g = document.querySelector('#IncriptionCheckBox');
        

    
        // Je vide le formulaire
        a.value = "";
        b.value = "";
        c.value = "";
        d.value = "";
        e.value = "";
        f.value = "";
        g.checked = false;

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