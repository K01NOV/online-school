function toggleTopic(header) {
        const topicItem = header.parentElement;
        if (topicItem) {
            topicItem.classList.toggle('open');
        }
    }

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

    const params = new URLSearchParams(window.location.search);
    const topicId = params.get('topic_id');

    if (topicId) {
        // 2. Ищем блок темы по нашему data-id
        const target = document.querySelector(`[data-topic-id="${topicId}"]`);
        if (target) {
            // 3. Находим заголовок, на который обычно кликают
            const header = target.querySelector('.topic-header');
            if (header) {
                // 4. Вызываем твою функцию раскрытия
                toggleTopic(header);
                
                // 5. На всякий случай плавно докручиваем
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
})