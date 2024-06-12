function toggleForm(idCita) {
    var form1 = document.getElementById('form_info-' + idCita);
    var form2 = document.getElementById('form-' + idCita);
    if (form2.classList.contains('show')) {
        form2.classList.remove('show');
        form1.classList.remove('hide');
    } else {
        form2.classList.add('show');
        form1.classList.add('hide');
    }
}
