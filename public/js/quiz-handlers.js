export function showQuiz() {
    let quiz = document.getElementById('quiz-block');
    if (quiz) {
        quiz.style.display = 'block';
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
}

export function checkAnswer(correct) {
    const input = document.getElementById('user-answer');
    if (!input) return;
    
    const user = input.value.trim().toLowerCase();
    if(user === correct.toLowerCase()) {
        alert('Верно! Ты молодец!');
    } else {
        alert('Попробуй еще раз!');
    }
}