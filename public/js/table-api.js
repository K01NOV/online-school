let inputs, delete_buttons, empty_inputs;

function refreshElements() {
    inputs = document.querySelectorAll('.ajax-input');
    delete_buttons = document.querySelectorAll('.ajax-delete');
    empty_inputs = document.querySelectorAll('.ajax-empty');
    console.log('ok')
    console.log('Текущие пустые инпуты:', empty_inputs);
}

async function send_api_request(data, route){
    // Отправляем запрос
    const response = await fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    const result = await response.json();
    return result;
}

function create_new_row(rowToClone) {
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

function convert_to_updatable(row, newId, tableName){
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
    console.log(lastId, row)
}

async function insert_value(input, token){
    if (input.value.trim() === '') return;
    let newData = {};
    let result;
    newData[input.name] = input.value;
    const data = {
        token:  token, 
        table:  input.dataset.table,
        data:  newData
    };
    // Визуальный эффект заморозки поля
    input.style.opacity = '0.5';
    input.disabled = true;
    try{
        result = await send_api_request(data, '/api/table/insert');
        if (result.success) {
            input.style.outline = '2px solid #28a745';
            setTimeout(() => input.style.outline = 'none', 1000);    
            const tableName = input.dataset.table;
            const currentRow = input.closest('tr');      
            create_new_row(currentRow); 
            convert_to_updatable(currentRow, result.id, tableName);   
            refreshElements();
        } else {
            alert('Ошибка: ' + result.error);
            input.style.outline = '2px solid #dc3545';
        }
    }catch (error) {
        alert('Не удалось связаться с сервером');
        console.error('AJAX Error:', error);
    } finally {
        input.style.opacity = '1';
        input.disabled = false;
    }
}

async function delete_row(button, token){
    const data = {
        token: token,
        table: button.dataset.table,
        id: button.dataset.id
    };
    button.style.opacity = '0.5';
    button.disabled = true;
    try {
        let result = await send_api_request(data, '/api/table/delete');
         if (result.success) {
            const row = button.closest('tr');
            if (row) {
                row.remove();
            }
            
        } else {
            alert('Ошибка: ' + result.error);
            button.style.outline = '2px solid #dc3545';
        }
    } catch (error) {
        alert('Не удалось связаться с сервером');
        console.error('AJAX Error:', error);
    } finally {
        button.style.opacity = '1';
        button.disabled = false;
        refreshElements();
    }
}

async function update_row(input, token){
    if (input.value.trim() === '') return;
    const data = {
        token:  token,
        table:  input.dataset.table,
        id:     input.dataset.id,
        column: input.name,
        value:  input.value
    };
    input.style.opacity = '0.5';
    input.disabled = true;
    try{
        let result = await send_api_request(data, '/api/table/update');
         if (result.success) {
            input.style.outline = '2px solid #28a745';
            setTimeout(() => input.style.outline = 'none', 1000);
            refreshElements();
        } else {
            alert('Ошибка: ' + result.error);
            input.style.outline = '2px solid #dc3545';
        }
    }catch (error) {
        alert('Не удалось связаться с сервером');
        console.error('AJAX Error:', error);
    } finally {
        input.style.opacity = '1';
        input.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="auth-token"]').getAttribute('content') ?? "";
    const table = document.querySelector('.bo-table');
    
    refreshElements();

    table.addEventListener('change', async function(e) {
        const target = e.target;
        if (target.classList.contains('ajax-empty')){
            await insert_value(target, token);
            return;
        }
        if (target.classList.contains('ajax-input')){
            await update_row(target, token);
            return;
        }

    })

    table.addEventListener('click', async function(e) {
        // Проверяем, что кликнули именно по кнопке DELETE
        if (e.target.classList.contains('ajax-delete')) {
            const btn = e.target;
            await delete_row(btn, token);
            return;
        }
    });

})