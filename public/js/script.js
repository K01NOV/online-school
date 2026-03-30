import { insert_value, delete_row, update_row, handleTopicBlur, handleLessonBlur } from './table-handlers.js';
import { showQuiz, checkAnswer } from './quiz-handlers.js';
import { initProgressBar, openTopicFromUrl, toggleTopic, showNewRow, hideNewRow, showNewLessonRow } from './ui-utils.js';
import { refreshElements } from './table-utils.js';

window.showQuiz = showQuiz;
window.checkAnswer = checkAnswer;
window.toggleTopic = toggleTopic;
window.showNewRow = showNewRow;
window.showNewLessonRow = showNewLessonRow;

document.addEventListener('DOMContentLoaded', function() {
    let roleSelector = document.querySelector('#selector');
    let nick = document.querySelector('#nick');
    const token = document.querySelector('meta[name="auth-token"]').getAttribute('content') ?? "";
    const table = document.querySelector('.bo-table');
    const newTopicInput = document.querySelector('.new-topic-row input');
    const container = document.querySelector('.accordion');
    const editor = document.querySelector('.lesson-json-editor');

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

    if (container) {
        container.addEventListener('change', async (event) => {
            const target = event.target;
            if (target.classList.contains('ajax-empty') && target.closest('.new-topic-row')) {
                await handleTopicBlur(target, token);
            }
            if (target.closest('.new-lesson-row')) {
                await handleLessonBlur(target, token); // Сейчас создадим эту функцию
            }
        });

        container.addEventListener('keypress', (event) => {
            if (event.key === 'Enter' && event.target.classList.contains('ajax-empty')) {
                event.target.blur();
            }
        });

        container.addEventListener('focusout', (event) => {
        const target = event.target;
        if (!target.classList.contains('ajax-empty')) return;

        if (target.value.trim() === '') {
            const topicRow = target.closest('.new-topic-row');
            const lessonRow = target.closest('.new-lesson-row');

            if (topicRow) hideNewRow('.new-topic-row');
            if (lessonRow) {
                lessonRow.classList.remove('visible');
            }
        }
    });
    }
    
})