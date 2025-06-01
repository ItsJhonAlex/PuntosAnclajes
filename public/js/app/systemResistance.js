$(document).ready(function() {

    $('#systemUseTable').DataTable({
        ajax: 'systemUse/table',
        processing: true,
        responsive: true,
        columns: [
            { data: 'id'},
            { data: 'uso_sistema_proteccion' },
            {
                // Columna para el botón de editar
                data: null,
                render: function (data, type, row) {
                    return `<a href="systemUse/edit/${row.id}" class="btn btn-primary">Editar</a>`;
                }
            },
            {
                // Columna para el botón de eliminar
                data: null,
                render: function (data, type, row) {
                    return `<a href="systemUse/delete/${row.id}" class="btn btn-danger">Eliminar</a>`;
                }
            },
        ],
    });
});