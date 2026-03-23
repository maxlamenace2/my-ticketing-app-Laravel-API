function check_email() {

    const checkemail1 = document.querySelector('#email-lost1');
    const checkemail2 = document.querySelector('#email-lost2');
    const lost_error_email_same = document.querySelector('#lost-error-email-same');
    if(!(checkemail1.value == checkemail2.value)) {
        lost_error_email_same.classList.remove('hidden');
        return 1;
    } else {
        lost_error_email_same.classList.add('hidden');
        return 0;
    }
}


const lost = document.querySelector('#mdp-lost');


lost.addEventListener("submit", function(event) {

    event.preventDefault();
    console.log('j\'ai soumis mon formulaire');

    
    let nb_errors = 0;
    nb_errors = check_email();

   
    if(nb_errors == 0) {
        const a = document.querySelector('#email-lost1');
        const b = document.querySelector('#email-lost2');
        
        // Je vide le formulaire
        a.value = "";
        b.value = "";

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