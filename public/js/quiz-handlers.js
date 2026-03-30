let solvedQuizzes = 0;
let correctAnswersCount = 0;

export function showQuiz() {
    let quiz = document.getElementById('quiz-block');
    if (quiz) {
        quiz.style.display = 'block';
    }
}

export function checkAnswer(button, correct) {
    const container = button.closest('.quiz-item');
    const allQuizzes = document.querySelectorAll('.quiz-item');
    const totalQuizzes = allQuizzes.length;
    const feedback = container.querySelector('.quiz-feedback');
    const textInput = container.querySelector('.quiz-answer-input');
    const selected = Array.from(container.querySelectorAll('input:checked')).map(el => el.value)
    
    let isCorrect = false;
    solvedQuizzes++;

    if (textInput) {
        const user = textInput.value.trim().toLowerCase();
        isCorrect = (user === correct.trim().toLowerCase());
        textInput.style.borderColor = isCorrect ? 'green' : 'red';
    } else {
        if (Array.isArray(correct)) {
            isCorrect = selected.length === correct.length && 
                        selected.every(val => correct.includes(val));
        } else {
            isCorrect = (selected.length === 1 && selected[0] === correct);
        }
    }

    if (isCorrect) {
        feedback.textContent = '✓ Верно';
        feedback.style.color = 'green';
        correctAnswersCount++;
    } else {
        feedback.textContent = '✕ Неправильно';
        feedback.style.color = 'red';
    }
    lockQuiz(container, button);

    if (solvedQuizzes === totalQuizzes) {
        showFinalResult(correctAnswersCount, totalQuizzes);
    }
}

function lockQuiz(container, button) {
    const inputs = container.querySelectorAll('input');
    inputs.forEach(input => {
        input.disabled = true;
        input.style.opacity = '0.6';
        input.style.cursor = 'not-allowed';
    });

    button.disabled = true;
    button.style.opacity = '0.5';
    button.style.cursor = 'not-allowed';
    button.textContent = 'Ответ принят';
}

function showFinalResult(correct, total) {
    const resultCard = document.getElementById('final-result-card');
    const percentSpan = document.getElementById('percent-result');
    const backBtn = document.getElementById('back-to-subject');
    const comment = document.getElementById('result-comment');

    const percent = Math.round((correct / total) * 100);
    
    resultCard.style.display = 'block';
    percentSpan.textContent = percent + '%';

    backBtn.style.opacity = '1';
    backBtn.style.pointerEvents = 'auto';
    backBtn.style.background = '#3498db';

    if (percent === 100) {
        comment.textContent = "Идеально! Вы полностью освоили материал.";
    } else if (percent >= 70) {
        comment.textContent = "Хороший результат! Есть над чем поработать.";
    } else {
        comment.textContent = "Материал усвоен частично. Рекомендуем перечитать урок.";
    }

    resultCard.scrollIntoView({ behavior: 'smooth' });

}