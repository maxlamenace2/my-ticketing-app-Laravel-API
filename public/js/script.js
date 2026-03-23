const menuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.querySelector('.sidebar');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });