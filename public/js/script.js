const item = document.querySelector('div>div>div>button')
const close = document.querySelector('div>p>button');

function toggleModal(){
const modal = document.getElementsByClassName('item');
modal.classList.toggle('show');
}

item.addEventListener('click', function(e){
    e.preventDefault();
    toggleModal();
});

close.addEventListener('click', function(e){
    e.preventDefault();
    toggleModal();
});