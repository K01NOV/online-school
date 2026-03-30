export function initProgressBar(barId) {
    const progressBar = document.getElementById(barId);
    if (!progressBar) return;

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    });
}

export function openTopicFromUrl() {
    const params = new URLSearchParams(window.location.search);
    const topicId = params.get('topic_id');

    if (topicId) {
        const target = document.querySelector(`[data-topic-id="${topicId}"]`);
        const header = target?.querySelector('.topic-header');
        if (header) {
            toggleTopic(header);
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

export function toggleTopic(header) {
    const topicItem = header.parentElement;
    if (topicItem) {
        topicItem.classList.toggle('open');
    }
}

export function showNewRow(rowClass) {
    const row = document.querySelector(rowClass);
    const input = row?.querySelector('input');
    
    if (row && input) {
        row.style.display = 'block'; // Сначала делаем доступным в DOM
        // Небольшой таймаут, чтобы браузер успел заметить display: block перед анимацией
        setTimeout(() => {
            row.classList.add('visible');
            input.focus();
        }, 10);
    }
}



export function hideNewRow(rowClass) {
    const row = document.querySelector(rowClass);
    if (row) {
        row.classList.remove('visible'); 
        setTimeout(() => {
            if (!row.classList.contains('visible')) {
                row.style.display = 'none';
                const input = row.querySelector('input');
                if (input) input.value = ''; 
            }
        }, 300); 
    }
}

export function showNewLessonRow(button) {
    const container = button.closest('.lessons-list-inner');
    const row = container?.querySelector('.new-lesson-row');
    const input = row?.querySelector('input');

    if (row && input) {
        row.style.display = 'flex'; // Уроки обычно flex или block
        setTimeout(() => {
            row.classList.add('visible');
            input.focus();
        }, 0);
    }
}

export function hideNewLessonRow(button) {
    const container = button.closest('.lessons-list-inner');
    const row = container?.querySelector('.new-lesson-row');
    if (row) {
        row.classList.remove('visible'); 
        setTimeout(() => {
            if (!row.classList.contains('visible')) {
                row.style.display = 'none';
                const input = row.querySelector('input');
                if (input) input.value = ''; 
            }
        }, 0); 
    }
}

export function openEditor(lessonId, currentContent) {
    const overlay = document.getElementById('lesson-editor-overlay');
    const textarea = document.getElementById('json-editor');
    
    // Инициализируем данные (функция будет ниже)
    window.initEditorState(currentContent); 
    
    // Сохраняем ID урока в дата-атрибут оверлея, чтобы потом знать, что сохранять
    overlay.dataset.currentLessonId = lessonId;
    
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

export function forceCloseEditor() {
    const overlay = document.getElementById('lesson-editor-overlay');
    overlay.classList.remove('active');
    document.body.style.overflow = 'auto';
}

export function handleEditorInput(textarea) {
    try {
        // Синхронизируем текстовое поле с внутренним состоянием
        window.lessonData = JSON.parse(textarea.value);
        textarea.style.borderColor = "dodgerblue"; 
    } catch (e) {
        textarea.style.borderColor = "red"; 
    }
}