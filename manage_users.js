document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Lógica del Checkbox "Seleccionar Todos"
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.getElementsByName('ids[]');

    if (selectAll) {
        selectAll.onclick = function() {
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    }

    // 2. Confirmación de seguridad antes de enviar
    const formManage = document.getElementById('form-manage');
    if (formManage) {
        formManage.onsubmit = function(e) {
            // Verificar si hay al menos uno seleccionado
            let checkedCount = 0;
            for (let checkbox of checkboxes) {
                if (checkbox.checked) checkedCount++;
            }

            if (checkedCount === 0) {
                alert('Por favor, selecciona al menos un usuario para eliminar.');
                return false;
            }

            return confirm(`¿Estás seguro de que deseas vaporizar a los ${checkedCount} usuarios seleccionados? Esta acción es irreversible.`);
        };
    }
});