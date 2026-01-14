const toggleEyes = document.querySelectorAll('.toggle-eye');

toggleEyes.forEach(toggleEye => {
    // CAMBIO: Usamos toggleEye (el nombre del parámetro del forEach)
    const passwordInput = toggleEye.previousElementSibling; 

    const mostrarPass = () => {
        passwordInput.type = 'text';
        toggleEye.classList.replace('fa-eye', 'fa-eye-slash');
    };

    const ocultarPass = () => {
        passwordInput.type = 'password';
        toggleEye.classList.replace('fa-eye-slash', 'fa-eye');
    };

    // Eventos Mouse
    toggleEye.addEventListener('mousedown', mostrarPass);
    toggleEye.addEventListener('mouseup', ocultarPass);
    toggleEye.addEventListener('mouseleave', ocultarPass);

    // Eventos Touch
    toggleEye.addEventListener('touchstart', (e) => {
        e.preventDefault(); 
        mostrarPass();
    });
    toggleEye.addEventListener('touchend', ocultarPass);
});