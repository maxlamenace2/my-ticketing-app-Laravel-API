
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

    const updateToast = document.getElementById('toast-update');
    
    if (updateToast) {
        
        updateToast.classList.add('show');
        setTimeout(() => {
            updateToast.classList.remove('show');
        }, 3000);
    }
    
    const btnUpload = document.getElementById('btn-upload');
    const realFileInput = document.getElementById('real-file-input');
    const fileNameDisplay = document.getElementById('file-name-display');
    const btnDownload = document.getElementById('btn-download');
    const uploadStatus = document.getElementById('upload-status');

    const toastUpdateSuccess = document.getElementById('update-project-toats-success');

    const btnDeleteContract = document.getElementById('btn-delete-contract');

    if (btnUpload && realFileInput) {
        
        // 1. Quand on clique sur le faux bouton, on déclenche le vrai input caché
        btnUpload.addEventListener('click', function() {
            realFileInput.click();
        });

        realFileInput.addEventListener('change', function() {
            if (realFileInput.files.length > 0) {
                const file = realFileInput.files[0];
                
                toastUpdateSuccess.classList.add('show');
                toastUpdateSuccess.innerText = "Upload en cours...";

                const projectId = realFileInput.getAttribute('data-project-id');
                
              
                const formData = new FormData();
                formData.append('contract_file', file); // ce que je recup dans le controller

                // Envoi à l'API
                fetch(`/api/projects/${projectId}/upload-contract`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('#contract-upload-form input[name="_token"]').value,
                        'Accept': 'application/json'
    
                    },
                    body: formData
                })
                .then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || "Erreur lors de l'upload");
                    }
                    return response.json();
                })
                .then(data => {
                    btnDownload.href = data.file_url;
                    btnDownload.style.pointerEvents = "auto";
                    btnDownload.style.opacity = "1";

                    if (fileNameDisplay) {
                        fileNameDisplay.innerText = data.file_name;
                    }
                    
                    if (btnDeleteContract) {
                        btnDeleteContract.style.display = "inline-block";
                    }
                    
                    toastUpdateSuccess.classList.add('show');
                    toastUpdateSuccess.innerText = "✅ " + data.message; 
            
                    setTimeout(() => {
                        toastUpdateSuccess.classList.remove('show');
                    }, 3000);
                    })
                .catch(error => {
                    console.error('Erreur API :', error);
                    uploadStatus.innerText = "❌ Erreur";
                    alert(error.message);
                });
            }
        });
    }
    

    if (btnDeleteContract) {
        btnDeleteContract.addEventListener('click', function() {
            
            const projectId = realFileInput.getAttribute('data-project-id');

            fetch(`/api/projects/${projectId}/delete-contract`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('#contract-upload-form input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                if (!response.ok) throw new Error("Erreur lors de la suppression");
                return response.json();
            })
            .then(data => {
                
                btnDownload.href = '#';
                btnDownload.style.pointerEvents = "none";
                btnDownload.style.opacity = "0.5";
                
               
                fileNameDisplay.innerText = "Aucun contrat";
                
                
                btnDeleteContract.style.display = "none";

                
                realFileInput.value = '';

            
                toastUpdateSuccess.classList.add('show');
                toastUpdateSuccess.innerText = "🗑️ " + data.message; 
                setTimeout(() => toastUpdateSuccess.classList.remove('show'), 3000);
            })
            .catch(error => alert(error.message));
        });
    }
});
