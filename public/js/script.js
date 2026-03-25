import { insert_value, delete_row, update_row } from './table-handlers.js';
import { showQuiz, checkAnswer } from './quiz-handlers.js';
import { initProgressBar, openTopicFromUrl, toggleTopic } from './ui-utils.js';
import { refreshElements } from './table-utils.js';

window.showQuiz = showQuiz;
window.checkAnswer = checkAnswer;
window.toggleTopic = toggleTopic;

document.addEventListener('DOMContentLoaded', function() {
    let roleSelector = document.querySelector('#selector');
    let nick = document.querySelector('#nick');
    const token = document.querySelector('meta[name="auth-token"]').getAttribute('content') ?? "";
    const table = document.querySelector('.bo-table');
    const add = document.querySelectorAll('.add');

    initProgressBar("myBar");
    openTopicFromUrl();
    if(table){
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
            // Проверяем что кликнули именно по кнопке DELETE
            if (e.target.classList.contains('ajax-delete')) {
                const btn = e.target;
                await delete_row(btn, token);
                return;
            }
        });
    }
    

    if (roleSelector && nick) { 
        roleSelector.addEventListener('change', function(){
            if (roleSelector.value == 'Личный аккаунт' || roleSelector.value == 'Ученик'){
                nick.style.display = 'block';
            } else {
                nick.style.display = 'none';
            }
        });
    }
    
})