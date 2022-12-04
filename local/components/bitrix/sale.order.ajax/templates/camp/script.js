function display(id){
    let conteiner=document.querySelector('#js-child-'+id)
    deactiveAll()
    conteiner.classList.add('active');
}
function deactiveAll(){
    let conteiners=document.querySelectorAll('.bx-soa-section-content.child')
    conteiners.forEach(element =>element.classList.remove('active'))
}
