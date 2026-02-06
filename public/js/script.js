document.addEventListener('DOMContentLoaded', function() {
    // 1. Работа с селектором аккаунта (Регистрация)
    let roleSelector = document.querySelector('#selector');
    let nick = document.querySelector('#nick');

    if (roleSelector && nick) { 
        roleSelector.addEventListener('change', function(){
            if (roleSelector.value == 'Личный аккаунт' || roleSelector.value == 'Ученик'){
                nick.style.display = 'block';
            } else {
                nick.style.display = 'none';
            }
        });
    }

    // 2. Логика прогресс-бара (Урок)
    let progressBar = document.getElementById("myBar");
    if (progressBar) {
        window.addEventListener('scroll', function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + "%";
        });
    }

    container = document.getElementById('results-container');
    const tabs = document.querySelectorAll('.tab');
    
    // Проверяем, есть ли на странице данные для поиска (из PHP через JSON)
    if (container && tabs.length > 0 && typeof searchData !== 'undefined') {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                renderResults(tab.dataset.type);
            });
        });
        const links = document.querySelectorAll(".classes-row a");
        console.log(links);
        links.forEach(link => {
            link.style.pointerEvents = 'none';
            link.addEventListener('click', (e) => e.preventDefault());
        })

        // Запуск начального состояния поиска
        renderResults('subjects');
    }
});

let container;
// Эту функцию выносим за пределы, так как она вызывается через onclick в HTML
function toggleTopic(header) {
    const topicItem = header.parentElement;
    if (topicItem) {
        topicItem.classList.toggle('open');
    }
}

// Функции для квиза (Урок)
function showQuiz() {
    let quiz = document.getElementById('quiz-block');
    if (quiz) {
        quiz.style.display = 'block';
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
}

function checkAnswer(correct) {
    const input = document.getElementById('user-answer');
    if (!input) return;
    
    const user = input.value.trim().toLowerCase();
    if(user === correct.toLowerCase()) {
        alert('Верно! Ты молодец!');
    } else {
        alert('Попробуй еще раз!');
    }
}

function createSubjectHTML(item) {
    return `
        <div class="result-item result-item--with-image">
            <div class="result-item__image-container">
                <img src="${item.image || '/assets/img/default.png'}" class="result-item__img" referrerpolicy="no-referrer">
            </div>
            <div class="result-item__content">
                <h3 class="result-item__title">${item.name}</h3>
                <p class="result-item__desc">${item.description || ''}</p>
                <a href="/subject-info?id=${item.id}" class="result-item__link">Перейти к предмету</a>
            </div>
        </div>`;
}
function createTopicHTML(item) {
    return `
        <div class="result-item">
            <div class="result-item__content">
                <h3 class="result-item__title">${item.name}</h3>
                <span class="result-item__subtitle">Предмет: ${item.subject_title || 'Не указан'}</span>
                <p class="result-item__desc">${item.description || ''}</p>
                <a href="/view/topics/${item.id}" class="result-item__link">Смотреть тему</a>
            </div>
        </div>`;
}
function createDefaultHTML(item, type) {
    const title = item.name || item.title || "Без названия";
    return `
        <div class="result-item">
            <div class="result-item__content">
                <h3 class="result-item__title">${title}</h3>
                <p class="result-item__desc">${item.description || ''}</p>
                <p class="result-item__subtitle">Тема: ${item.topic_title || 'Не указан'}</p>
                <p class="result-item__subtitle">Предмет: ${item.subject_title || 'Не указан'}</p>
                <a href="/lesson?id=${item.id}" class="result-item__link">Открыть</a>
            </div>
        </div>`;
}

function renderResults(type) {
    const items = searchData[type] || [];
    if (!container) return;
    container.innerHTML = '';
    if (items.length === 0) {
        container.innerHTML = `
            <div class="search-placeholder">
                <img src="/assets/placeholder.png" alt="Пусто" class="placeholder-image">
                <h2 class="placeholder-text">По вашему запросу ничего не найдено</h2>
            </div>`;
        return;
    }
    items.forEach(item => {
        let html = '';
        
        // Выбираем нужную функцию сборки HTML
        if (type === 'subjects') {
            html = createSubjectHTML(item);
        } else if (type === 'topics') {
            html = createTopicHTML(item);
        } else {
            html = createDefaultHTML(item, type);
        }
        
        container.insertAdjacentHTML('beforeend', html);
    });
}