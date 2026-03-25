let inputs, delete_buttons, empty_inputs;

export function refreshElements() {
    inputs = document.querySelectorAll('.ajax-input');
    delete_buttons = document.querySelectorAll('.ajax-delete');
    empty_inputs = document.querySelectorAll('.ajax-empty');
}



export function create_new_row(rowToClone) {
    const tableBody = rowToClone.parentNode;
    const newRow = rowToClone.cloneNode(true);
    
    const newInputs = newRow.querySelectorAll('input');
    newInputs.forEach(input => {
        if (input.type !== 'hidden') {
            input.value = '';
        } else {
            const span = newRow.querySelector('span');
            if (span) {
                let currentId = parseInt(span.textContent);
                span.textContent = isNaN(currentId) ? 1 : currentId + 1;
            }
        }
        input.style.outline = 'none';
        input.style.opacity = '1';
        input.disabled = false;
    });
    
    tableBody.appendChild(newRow);
}

export function convert_to_updatable(row, newId, tableName){
    const rowInputs = row.querySelectorAll('input');
    rowInputs.forEach(input => {
        input.classList.remove('ajax-empty');
        input.classList.add('ajax-input');
        input.dataset.id = newId;
    });
    const lastId = row.cells[row.cells.length - 1];
    lastId.innerHTML = `
        <button 
            class="bo-btn-delete ajax-delete" 
            data-id="${newId}" 
            data-table="${tableName}"
        >DELETE</button>
    `;
}
