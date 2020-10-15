$(document).ready(function(e) {//Cuando carga el DOM Ejecutamos lo que hay dentro
    cargarLista(null)
    var actualizar = false//Variable que comrpueba si La operacion es Insertar o Actualizar
    function cargarLista(sel){
        $.ajax({ //Enviamos una petición al servidor PHP
            url: '../senasoft/controlador/cubicacion.php',
            type: 'POST',
            data: {
                operacion: 'ciudades'
            },      
            success: function (res) { //Recibimos Respuesta
                var cont = ''
                //console.log(res)
                const ubi = JSON.parse(res) //Convertimos esa respuesta en JSON
                ubi.forEach(u => {
                    cont += `
                        <option value="${u.idubi}"
                    `
                    if(sel == u.idubi) cont += `selected`
                    cont += `
                        >${u.muni} - ${u.depto}</option>
                    `//Generamos las Opciones dentro de Lista desplegable
                });
                $('#depende').html(cont)//Imprimimos Opciones dentro de Lista desplegable
            }
        })
    }

    $('#formulario').submit(function(e){//Funcion cuando se haga el envío de datos
        var datos = $('#formulario').serialize()//Recolectamos los datos del formulario
        if (actualizar == false) datos += '&operacion=Insertar'//Enviamos un parametro operación al servidor si la operacion es insertar
        else datos += '&operacion=Actualizar'//En caso de que la operacion sea actualizar enviamos al servidor el dato
        //console.log(datos)
        $.post('senasoft/controlador/cubicacion.php',datos,function(res){//Una petición POST al servidor PHP enviando los datos recolectados
            //console.log(res)
            actualizar = false
            $('#id_').show()
            $('#registrar').val('Registrar Servicio')
            cargarDatos()
            $('#formulario').trigger('reset')
        })//Terminada la ejecución dejamos todo por defecto
        //console.log(datos)
        e.preventDefault()//Prevenimos que la página se recargue
    })

    function cargarDatos(){//Función que pinta los datos en la parte inferior
        const buscar = $('#buscador').val()//Tomamos lo que halla en el campo de buscar
        $.ajax({//Hacemos una petición POST al servidor PHP
            url: 'controlador/cubicacion.php',
            type: 'POST',
            data: {
                operacion: 'mosubi',
                buscar: buscar
            },
            success: function (res) {//Si arroja un resultado Se muestra aquí
                if (res != 'null'){
                    var cont = `
                        <table class="table table-striped">
                        <thead>
                            <td class="cab" class="cab" align="center" scope="col"><p class="ltp2 text-secondary float-left">Datos de Centro</p></td>
                        </thead>
                    `//Se crea la cabecera de la tabla
                    //console.log(res)
                    const ubi = JSON.parse(res)//Convertimos el resultado en JSON
                    ubi.forEach(u => {//Un ciclo que nos pinta las opciones
                        cont += `
                           <tr idubi="${u.idubi}">
                               <td>
                                   <p class="ltp2">${u.centro}</p>
                                   <b>Ciudad/municipio: </b>${u.muni}<br>
                                   <b>Departamento:</b> ${u.depto}
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
                }else{
                    $('#registros').html('<h1 align="center">No hay datos registrados</h1>')
                }
            }
        })
    }
    $(document).on('click','.eliminar',function(){//Función para que el formulario elimine
        let tr = $(this)[0].parentElement.parentElement//Llamamos al elemento padre del campo HTML
        let id = $(tr).attr('idubi')//Buscamos el atributo "idubi" dentro de la etiqueta padre
        let datos = 'idubi='+id+'&operacion=Eliminar'//La operacion será Eliminar en el servidor
        //console.log(datos)
        if(confirm('¿Deseas eliminar la ubicación?')){//Desplegamos un alert donde pedimos confirmacion al usuario
            $.post('senasoft/controlador/cubicacion.php',datos,function(res){
                console.log(res)
                cargarDatos()
            })
        }
    })

    $(document).on('click', '.actualizar', function () {//Función para actualizar registros
        let tr = $(this)[0].parentElement.parentElement
        let id = $(tr).attr('idubi')
        let datos = 'idubi='+id+'&operacion=Seleccionar'
        $.post('senasoft/controlador/cubicacion.php', datos, function (res) {
            actualizar = true
            const datos = JSON.parse(res)
            $('#id').val(datos.idubi)
            $('#nombre').val(datos.centro)
            $('#id_').hide()
            $('#registrar').val('Actualizar Servicio')
            cargarLista(datos.idmun)
        })
    })
    $('#buscador').on('input',cargarDatos)
    cargarDatos()
    $('#id').on('input',lleno)
    $('#nombre').on('input', lleno)
    $('#depende').on('change', lleno)
    //Agregamos eventos a los objetos, con el fin de Saber si el formulario está lleno o vacío
    function lleno(){
        if ($('#id').val() != '' && $('#nombre').val() != '' && $('#depende').val() != ''){
            $('#registrar').css('background-color', '')
            $('#registrar').attr('disabled',false)
        }
        else{
            $('#registrar').css('background-color','grey')
            $('#registrar').attr('disabled', true)
        }
    }
})