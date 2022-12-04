function display(id){
    let conteiner=document.querySelector('#js-child-'+id)
    deactiveAll()
    conteiner.classList.add('active');
}
function deactiveAll(){
    let conteiners=document.querySelectorAll('.bx-soa-section-content.child')
    conteiners.forEach(element =>element.classList.remove('active'))
}

//<input required pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="10.02.2001" name="date_born" type="text">