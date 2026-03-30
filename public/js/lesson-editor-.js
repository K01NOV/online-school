export function initEditorState(content) {
    const editor = document.querySelector('.lesson-json-editor');
    try {
        window.lessonData = content ? JSON.parse(content) : [];
        editor.value = JSON.stringify(window.lessonData, null, 2);
    } catch (e) {
        window.lessonData = [];
        editor.value = "[]";
    }
}

export function addSnippet(type) {
    const editor = document.querySelector('.lesson-json-editor');
    let newBlock = {};

    switch(type) {
        case 'header': newBlock = { "type": "header", "content": "Заголовок" }; break;
        case 'text': newBlock = { "type": "text", "content": "Текст" }; break;
        case 'image': newBlock = { "type": "image", "url": "url" }; break;
        case 'video': newBlock = { "type": "video", "id": "id", "url": "url" }; break;
        case 'quiz_options': 
            newBlock = { "type": "quiz", "subtype": "choice", "q": "Вопрос?", "a": ["1", "2"], "correct": 0 }; 
            break;
        case 'quiz_input': 
            newBlock = { "type": "quiz", "subtype": "input", "q": "Вопрос?", "a": [], "correct": "ответ" }; 
            break;
    }

    window.lessonData.push(newBlock);
    editor.value = JSON.stringify(window.lessonData, null, 2);
}