function confirmaExclusao(value) {

    var frm = document.getElementById('form_' + value) || null;
    if (confirm('Confirma a exclusão do arquivo?')) {
        frm.submit();
    }
}