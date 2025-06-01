$(document).ready(function() {

    $('#protectionSystemTable').DataTable({
        ajax: 'protectionSystem/table',
        processing: true,
        responsive: true,
        columns: [
            { data: 'id'},
            { data: 'nombre' },
            {
                // Columna para el botón de editar
                data: null,
                render: function (data, type, row) {
                    return `<a href="protectionSystem/edit/${row.id}" class="btn btn-primary">Editar</a>`;
                }
            },
            {
                // Columna para el botón de eliminar
                data: null,
                render: function (data, type, row) {
                    return `<a href="protectionSystem/delete/${row.id}" class="btn btn-danger">Eliminar</a>`;
                }
            },
        ],
    });
});