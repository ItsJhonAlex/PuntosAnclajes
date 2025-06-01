$(document).ready(function() {

    console.log('empresasTabla');


    $('#empresasTabla').DataTable({
        ajax: 'company/table',
        processing: true,
        responsive: true,
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'sede' },
            { data: 'ciudad' },
            { data: 'nit' },
            { data: 'nombre_contacto_empresa' },
            { data: 'telefono_contacto_empresa' },
            { data: 'email_contacto_empresa' },
            { data: 'nombre_contacto_empresa_2' },
            { data: 'telefono_contacto_empresa_2' },
            {
                // Columna para el botón de editar
                data: null,
                render: function (data, type, row) {
                    return `<a href="company/edit/${row.id}" class="btn btn-primary">Editar</a>`;
                },
                className: 'dt-body-center'  // Updated to use className
            },
            {
                // Columna para el botón de eliminar
                data: null,
                render: function (data, type, row) {
                    return `<a href="company/delete/${row.id}" class="btn btn-danger">Eliminar</a>`;
                },
                className: 'dt-body-center'  // Updated to use className
            },
        ],
    });

    // $('#empresasTabla').DataTable({
    //     responsive: true,
    //     bProcessing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: "company/table",
    //         dataSrc: "aaData",
    //     },
    //     rowReorder: {
    //         selector: "td:nth-child(2)",
    //     },
    //     order: [[17, 'desc']],
    //     aoColumnDefs: [
    //         {
    //             mData: 'nombre',
    //             aTargets: [0],
    //         },
    //         {
    //             mData: 'sede',
    //             aTargets: [1],
    //         },
    //         {
    //             mData: 'ciudad',
    //             aTargets: [2],
    //         },
    //         {
    //             mData: 'nit',
    //             aTargets: [3],
    //         },
    //         {
    //             mData: 'nombre_contacto_empresa',
    //             aTargets: [4],
    //         },
    //         {
    //             mData: 'telefono_contacto_empresa',
    //             aTargets: [5],
    //         },
    //         {
    //             mData: 'email_contacto_empresa',
    //             aTargets: [6],
    //         },
    //         {
    //             mData: 'nombre_contacto_empresa_2',
    //             aTargets: [7],
    //         },
    //         {
    //             mData: 'telefono_contacto_empresa_2',
    //             aTargets: [8],
    //         },
    //         {
    //             mData: 'email_contacto_empresa_2',
    //             aTargets: [9],
    //         },
            
    //     ],
    // });
    
});
