document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="auth-token"]').getAttribute('content') ?? "";
    const inputs = document.querySelectorAll('.ajax-input');
    const delete_buttons = document.querySelectorAll('.ajax-delete');
    const empty_inputs = document.querySelectorAll('.ajax-empty');

    empty_inputs.forEach(input => {
        input.addEventListener('keydown', async function(e) {
            // Проверяем, нажат ли Enter
            if (e.key === 'Enter') {
                let newData = {};
                newData[input.name] = this.value;
                
                // Собираем данные
                const data = {
                    token:  token, 
                    table:  this.dataset.table,
                    data:  newData
                };
                console.log(data);
                // Визуальный эффект: "замораживаем" поле на время запроса
                this.style.opacity = '0.5';
                this.disabled = true;

                try{
                    let result = await send_api_request(data, '/api/table/insert');
                     if (result.success) {
                        // Успех: подсветим на секунду зеленым
                        this.style.outline = '2px solid #28a745';
                        setTimeout(() => this.style.outline = 'none', 1000);
                    } else {
                        // Ошибка от сервера (например, не админ)
                        alert('Ошибка: ' + result.error);
                        this.style.outline = '2px solid #dc3545';
                    }
                }catch (error) {
                    // Ошибка сети или сервера
                    alert('Не удалось связаться с сервером');
                    console.error('AJAX Error:', error);
                } finally {
                    // Возвращаем поле в рабочее состояние
                    this.style.opacity = '1';
                    this.disabled = false;
                    this.focus(); // Возвращаем фокус
                }
            }
        });
    });

    delete_buttons.forEach(input => {
        input.addEventListener('click', async function(e) {
            const data = {
                token: token, // Тот самый токен защиты
                table: this.dataset.table,
                id: this.dataset.id
            };
            // Визуальный эффект: "замораживаем" поле на время запроса
            this.style.opacity = '0.5';
            this.disabled = true;
            try {
                let result = await send_api_request(data, '/api/table/delete');
                 if (result.success) {
                    const row = this.closest('tr');
                    // 2. Если нашли, удаляем его
                    if (row) {
                        row.remove();
                    }
                } else {
                    // Ошибка от сервера (например, не админ)
                    alert('Ошибка: ' + result.error);
                    this.style.outline = '2px solid #dc3545';
                }
            } catch (error) {
                // Ошибка сети или сервера
                alert('Не удалось связаться с сервером');
                console.error('AJAX Error:', error);
            } finally {
                // Возвращаем поле в рабочее состояние
                this.style.opacity = '1';
                this.disabled = false;
                this.focus(); // Возвращаем фокус
            }
        })
    })

    inputs.forEach(input => {
        input.addEventListener('keydown', async function(e) {
            // Проверяем, нажат ли Enter
            if (e.key === 'Enter') {

                // Собираем данные
                const data = {
                    token:  token, // Тот самый токен защиты
                    table:  this.dataset.table,
                    id:     this.dataset.id,
                    column: this.name,
                    value:  this.value
                };

                // Визуальный эффект: "замораживаем" поле на время запроса
                this.style.opacity = '0.5';
                this.disabled = true;

                try{
                    let result = await send_api_request(data, '/api/table/update');
                     if (result.success) {
                        // Успех: подсветим на секунду зеленым
                        this.style.outline = '2px solid #28a745';
                        setTimeout(() => this.style.outline = 'none', 1000);
                    } else {
                        // Ошибка от сервера (например, не админ)
                        alert('Ошибка: ' + result.error);
                        this.style.outline = '2px solid #dc3545';
                    }
                }catch (error) {
                    // Ошибка сети или сервера
                    alert('Не удалось связаться с сервером');
                    console.error('AJAX Error:', error);
                } finally {
                    // Возвращаем поле в рабочее состояние
                    this.style.opacity = '1';
                    this.disabled = false;
                    this.focus(); // Возвращаем фокус
                }
            }
        });
    });

    async function send_api_request(data, route){
        // 3. Отправляем запрос
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
})