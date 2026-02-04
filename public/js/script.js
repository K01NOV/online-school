let type = document.querySelector('#selector');
let nick = document.querySelector('#nick');
type.addEventListener('change', function(){
    if (type.value == 'Личный аккаунт' || type.value == 'Ученик'){
        nick.style.display = 'block';
    } else{
        nick.style.display = 'none';
    }
})

function toggleTopic(header) {
    // Находим родительский элемент (topic-item)
    const topicItem = header.parentElement;
    
    // Переключаем класс open
    topicItem.classList.toggle('open');
    
    // (Опционально) Закрывать другие темы при открытии новой
    /*
    document.querySelectorAll('.topic-item').forEach(item => {
        if (item !== topicItem) {
            item.classList.remove('open');
        }
    });
    */
}