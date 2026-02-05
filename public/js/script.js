document.addEventListener('DOMContentLoaded', function() {
    // 1. Работа с селектором аккаунта (Регистрация)
    let type = document.querySelector('#selector');
    let nick = document.querySelector('#nick');

    if (type && nick) { // Выполнится только если элементы найдены
        type.addEventListener('change', function(){
            if (type.value == 'Личный аккаунт' || type.value == 'Ученик'){
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
});

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