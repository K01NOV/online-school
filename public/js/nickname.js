let type = document.querySelector('#selector');
let nick = document.querySelector('#nick');
type.addEventListener('change', function(){
    if (type.value == 'Личный аккаунт' || type.value == 'Ученик'){
        nick.style.display = 'block';
    } else{
        nick.style.display = 'none';
    }
})