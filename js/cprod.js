$(document).ready(function() {
    cargarDatos()
    var actualizar = false
    $('#check').on('click', function () {
        if ($(this).is(':checked')) {
            $('#paq').attr('disabled', false)
        } else {
            $('#paq').attr('disabled', true)
        }
    });

    $('#formulario').submit(function (e) {//Funcion cuando se haga el envío de datos
        var datos = $('#formulario').serialize()//Recolectamos los datos del formulario
        if (actualizar == false) datos += '&operacion=Insertar'//Enviamos un parametro operación al servidor si la operacion es insertar
        else datos += '&operacion=Actualizar'//En caso de que la operacion sea actualizar enviamos al servidor el dato

        $.post('controlador/cproducto.php', datos, function (res) {//Una petición POST al servidor PHP enviando los datos recolectados
            actualizar = false
            $('#paq').attr('disabled', true)
            $('#registrar').val('Registrar')
            cargarDatos()
            $('#formulario').trigger('reset')
        })//Terminada la ejecución dejamos todo por defecto
        //console.log(datos)
        e.preventDefault()//Prevenimos que la página se recargue
    })

    function cargarDatos() {//Función que pinta los datos en la parte inferior
        const buscar = $('#buscador').val()//Tomamos lo que halla en el campo de buscar
        $.ajax({//Hacemos una petición POST al servidor PHP
            url: 'controlador/cproducto.php',
            type: 'POST',
            data: {
                operacion: 'mosprod',
                buscar: buscar
            },
            success: function (res) {//Si arroja un resultado Se muestra aquí
                if (res != 'null') {
                    var cont = `
                        <table class="table table-striped">
                        <thead>
                            <td class="cab" class="cab" align="center" scope="col"><p class="ltp2 text-secondary float-left">Datos de Centro</p></td>
                        </thead>
                    `//Se crea la cabecera de la tabla
                    //console.log(res)
                    const reg = JSON.parse(res)//Convertimos el resultado en JSON
                    reg.forEach(u => {//Un ciclo que nos pinta las opciones
                        cont += `
                           <tr idprod="${u.idprod}">
                               <td>
                                   <p class="ltp2">${u.nombre}</p>
                                   <b>Precio: </b>${u.precio}<br>
                                   <b>Cantidad:</b> ${u.cant}<br>
                                   <b>Unidades</b> ${u.unid}<br>
                                   <b>Proveedor</b> ${u.proveedor}
                               </td>
                               <td>
                                    <button class="btn btn-danger eliminar mr-2">Eliminar</button>
                                    <button class="btn btn-success actualizar">Actualizar</button>
                               </td>
                           </tr>
                        `
                    });
                    cont += '</table>'
                    $('#registros').html(cont)//Mostramos en pantalla los resultados
                } else {
                    $('#registros').html('<h1 align="center">No hay datos registrados</h1>')
                }
            }
        })
    }

    $(document).on('click', '.eliminar', function () {//Función para que el formulario elimine
        let tr = $(this)[0].parentElement.parentElement//Llamamos al elemento padre del campo HTML
        let id = $(tr).attr('idprod')//Buscamos el atributo "idprod" dentro de la etiqueta padre
        let datos = 'idprod=' + id + '&operacion=Eliminar'//La operacion será Eliminar en el servidor
        //console.log(datos)
        if (confirm('¿Deseas eliminar la ubicación?')) {//Desplegamos un alert donde pedimos confirmacion al usuario
            $.post('controlador/cproducto.php', datos, function (res) {
                console.log(res)
                cargarDatos()
            })
        }
    })

    $(document).on('click', '.actualizar', function () {//Función para actualizar registros
        let tr = $(this)[0].parentElement.parentElement
        let id = $(tr).attr('idprod')
        let datos = 'idprod=' + id + '&operacion=Seleccionar'
        $.post('controlador/cproducto.php', datos, function (res) {
            //$('#er').html(res)
            actualizar = true
            const datos = JSON.parse(res)
            $('#id').val(datos.idprod)
            $('#desc').val(datos.nombre)
            $('#precio').val(datos.precio)
            $('#cantidad').val(datos.cant)
            $('#paq').val(datos.cant)
            $('#paq').attr('disabled', false)
            $('#registrar').val('Actualizar')
        })
    })
    $('#buscador').on('input',cargarDatos)
})