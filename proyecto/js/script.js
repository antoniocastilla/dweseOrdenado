/* global $ */
(function () {

    var btConfirmDelete = document.getElementById('btConfirmDelete');
    var checkAll = document.getElementById('checkAll');
    var fBorrar = document.getElementById('fBorrar');
    var tabla = document.getElementById('tablaProducto');

    if(btConfirmDelete) {
        btConfirmDelete.addEventListener('click', function() {
            $('#confirm').modal('hide'); //jquery
            fBorrar.submit();
        });
    }

    if(fBorrar) {
        fBorrar.addEventListener('submit', confirmDelete);
    }
    
    if(checkAll) {
        checkAll.addEventListener('click', checkTable);
    }
    
    if(tabla) {
        tabla.addEventListener('click', clickTable);
    }

    function checkTable() {
        var checkItems = document.getElementsByName('ids[]');
        for (var i = 0; i < checkItems.length; i++) {
            checkItems[i].checked = checkAll.checked;
        }
    }

    function clickTable(event) {
        var target = event.target;
        if(target.tagName === 'A' && target.getAttribute('class') === 'borrar') {
            confirmDelete(event);
        } else if(target.tagName === 'A' && target.getAttribute('class') === 'editar') {
            event.preventDefault();
            var dataId = target.getAttribute('data-id');
            var id = document.getElementById('id');
            id.value = dataId;
            var fEditar = document.getElementById('fEditar');
            fEditar.submit();
        }
    }

    function confirmDelete(event) {
        if(!confirm('¿De verdad?')) {
            event.preventDefault();
        }
    }

})();