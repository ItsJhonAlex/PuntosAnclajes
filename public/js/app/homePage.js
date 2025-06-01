$(document).ready(function () {

    $('#puntosAnclajeTabla').DataTable({
        responsive: true,
        bProcessing: true,
        serverSide: true,
        ajax: {
            url: "obtenerPuntosDeAnclaje",
            dataSrc: "aaData",
        },
        rowReorder: {
            selector: "td:nth-child(2)",
        },
        order: [[18, 'desc']],
        aoColumnDefs: [
            {
                mData: 'propuesta_instalacion',
                aTargets: [0],
            },
            {
                mData: 'sistema_proteccion',
                aTargets: [1],
            },
            {
                mData: null,
                mRender: function (data, type, row) {
                    return row.empresa;
                },
                aTargets: [2],
            },
            {
                mData: 'precinto',
                aTargets: [3],
            },
            {
                mData: 'serial',
                aTargets: [4],
            },
            {
                mData: 'instalador',
                aTargets: [5],
            },
            {
                mData: 'persona_calificada',
                aTargets: [6],
            },
            {
                mData: 'fecha_instalacion',
                aTargets: [7],
            },
            {
                mData: 'fecha_inspeccion',
                aTargets: [8],
            },
            {
                mData: 'fecha_proxima_inspeccion',
                aTargets: [9],
            },
            {
                mData: 'marca',
                aTargets: [10],
            },
            {
                mData: 'numero_usuarios',
                aTargets: [11],
            },
            {
                mData: 'uso',
                aTargets: [12],
            },
            {
                mData: 'resistencia',
                aTargets: [13],
            },
            {
                mData: null,
                mRender: function (data, type, row) {
                    let uso = "";
                    if (row.estado == 'NO APROBADO') {
                        return `<button type="button" class="btn btn-danger btn-sm">NO APROBADO</button>`
                    }
                    else {
                        return `<button type="button" class="btn btn-success btn-sm">APROBADO</button>`
                    }
                },
                aTargets: [14],
            },
            {
                mData: 'ubicacion',
                aTargets: [15],
            },
            {
                mData: 'observaciones',
                aTargets: [16],
            },
            {
                mData: null,
                mRender: function (data, type, row) {
                    return  `<a href="editarPuntoAnclaje/${row.id}" class="btn btn-success">editar</a>`
                },
                aTargets: [17],
            },      
            {
                mData: 'id',
                aTargets: [18],
            }
        ]

        
    });
 
});
