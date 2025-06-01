$(document).ready(function() {

    $('#workersTable').DataTable({
        ajax: 'worker/table',
        processing: true,
        responsive: true,
        columns: [
            { data: 'id'},
            { data: 'nombre' },
            { data: 'telefono' },
            {
                // Columna para el botón de editar
                data: null,
                render: function (data, type, row) {
                    return `<a href="worker/edit/${row.id}" class="btn btn-primary">Editar</a>`;
                }
            },
            {
                // Columna para el botón de eliminar
                data: null,
                render: function (data, type, row) {
                    return `<a href="worker/delete/${row.id}" class="btn btn-danger">Eliminar</a>`;
                }
            },
        ],
    });
});