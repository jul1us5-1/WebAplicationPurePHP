    const form = document.getElementById('changePassForm');
    const password1 = document.getElementById('password1');
    const password2 = document.getElementById('password2');
    const errorMsg = document.getElementById('errorMsg');

    form.addEventListener('submit', function(e){
        errorMsg.textContent = ''; // limpiar mensajes previos
        const pass1 = password1.value;
        const pass2 = password2.value;

        if(pass1.length < 8){
            errorMsg.textContent = "La contraseña debe tener al menos 8 caracteres.";
            e.preventDefault();
            return;
        }
        if(!/[a-zA-Z]/.test(pass1) || !/[0-9]/.test(pass1)){
            errorMsg.textContent = "La contraseña debe contener letras y números.";
            e.preventDefault();
            return;
        }
        if(pass1 !== pass2){
            errorMsg.textContent = "Las contraseñas no coinciden.";
            e.preventDefault();
            return;
        }
    });