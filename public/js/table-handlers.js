import { send_api_request } from './api.js';
import { create_new_row, convert_to_updatable, refreshElements } from './table-utils.js';

export async function insert_value(input, token){
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

export async function delete_row(button, token){
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

export async function update_row(input, token){
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