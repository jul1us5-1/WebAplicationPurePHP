const form = document.querySelector('.form-register');
const passwordInput = document.querySelector('input[name="password"]');
const passwordConfirmInput = document.querySelector('input[name="password_confirm"]');
form.addEventListener('submit',function(e){
    const password = passwordInput.value;
    const passwordConfirm = passwordConfirmInput.value;
    //para validar la seguridad de la constraseña se utiliza un Regex
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    
    if(!passwordRegex.test(password)){
        alert('La contraseña debe tener mínimo 8 caracteres, incluir mayúsculas, minúsculas, un número y un símbolo.');
        e.preventDefault();
        return;
    }
    if (password !== passwordConfirm) {
        alert('Las contraseñas no coinciden.');
        e.preventDefault();
    }
});
