function openProjectModal() {
    document.getElementById('projectModal').style.display = 'block';
}

function closeProjectModal() {
    document.getElementById('projectModal').style.display = 'none';
}


document.addEventListener("DOMContentLoaded", function () {

    

    const form = document.getElementById('api-project-form');
    const tableBody = document.querySelector('.project-table tbody')
    const CreateToast = document.getElementById('toast-create');
    

    if (form) {
        form.addEventListener('submit', async function (event) {

            event.preventDefault();

            const data = {
                "project-name": form.querySelector('input[name="project-name"]').value,
                "project-client": form.querySelector('input[name="project-client"]').value,
                "project-details": form.querySelector('textarea[name="project-details"]').value,
                "collaborators": form.querySelector('input[name="collaborators"]').value
            };

            const formData = JSON.stringify(data)

            const csrfToken = form.querySelector('input[name="_token"]').value;


            const response = await fetch("/api/projects", {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
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

            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                    <td>${message.project.ProjectName}</td>
                    <td>
                        <span class = "ClientName">
                            ${message.project.Client || ''}
                        </span>
                    </td>
                    <td><p>${message.project.Description || ''}</p></td>
                    <td>
                        ${message.project.Collaborateur || ''}
                    </td>
                    <td class="center"> 
                        <a href="${message.project.show_url}" class="project-open_btn">Open</a>
                    </td>
                    <td class="center"> 
                        <form class="api-delete-project" data-id="${message.project.id}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="project-remove_btn">Remove</button>
                        </form>
                    </td>
                `;

            tableBody.append(newRow);

            if (CreateToast) {
                CreateToast.classList.add('show');
                setTimeout(() => {
                    CreateToast.classList.remove('show');
                }, 3000);
            }


            form.reset();

        });
    }
});

document.addEventListener('submit', async function (event) {

    if (event.target && event.target.classList.contains('api-delete-project')) {

        event.preventDefault();

        const form = event.target;
        const row = form.closest('tr');

        const csrfToken = form.querySelector('input[name="_token"]').value;

        const id = form.getAttribute("data-id");

        const reponse = await fetch(`/api/projects/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
    
        if (reponse.ok) {
            row.classList.add('fade-out-row');

            setTimeout(() => {
                row.remove();
            }, 500);

        } else {
            alert("Erreur lors de la suppression. Vous n'avez peut-être pas les droits.");
        }
    

    }
});


