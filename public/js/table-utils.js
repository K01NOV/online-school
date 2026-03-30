let inputs, delete_buttons, empty_inputs, topic_inputs, new_topic;

export function refreshElements() {
    inputs = document.querySelectorAll('.ajax-input');
    delete_buttons = document.querySelectorAll('.ajax-delete');
    empty_inputs = document.querySelectorAll('.ajax-empty');
    topic_inputs = document.querySelectorAll('.topic-item');
    new_topic = document.querySelectorAll('.new-topic-row')
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

export function clone_row(rowToClone) {
    if (!rowToClone) {
        console.error("clone_row: Элемент для клонирования не найден");
        return null;
    }
    const parent = rowToClone.parentElement;
    if (!parent) {
        console.error("clone_row: У элемента нет родителя");
        return null;
    }
    const addButton = parent.querySelector('.add'); 
    const newRow = rowToClone.cloneNode(true);
    newRow.classList.remove('visible'); 
    newRow.style.display = 'none';
    const input = newRow.querySelector('input');
    if (input) {
        input.value = '';
        input.disabled = false;
    }
    try {
        if (addButton && addButton.parentNode === parent) {
            parent.insertBefore(newRow, addButton);
        } else {
            parent.appendChild(newRow);
        }
    } catch (e) {
        console.warn("Ошибка вставки, используем appendChild:", e);
        parent.appendChild(newRow);
    }
    
    return newRow;
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

export function transformToFinishedTopic(newRow, newId, topicName) {
    newRow.classList.remove('new-topic-row', 'visible');
    newRow.id = `topic-${newId}`;
    newRow.dataset.topicId = newId;

    newRow.innerHTML = `
        <div class="topic-header" onclick="toggleTopic(this)">
            <div class="topic-marker"></div>
            <h3 class="topic-name">${topicName}</h3>
            <span class="topic-status">0 уроков</span>
        </div>
        <div class="lessons-list">
            <div class="lessons-list-inner">
                <button onclick="showNewLessonRow(this)" class="add" data-action="add-lesson">
                    <img src="/assets/plus.svg" alt="">
                </button>
            </div>
        </div>
    `;
}

export function transformToFinishedLesson(row, id, name) {
    row.classList.remove('new-lesson-row', 'visible');
    row.href = `/lesson&id=${id}`;
    
    row.innerHTML = `
        <div class="lesson-marker-orange"></div>
        <span>${name}</span>
    `;
}