var subtotal = 0
$(document).ready(function(){
    //Inicializamos variables previamente
    var tot = ''

    cargarDatos()
    //Inicializar las tablas de productos
    var cont = `
        <table class="table table-hover">
            <thead>
                <td><p class="h5">Nombre</p></td>
                <td><p class="h5">Precio</p></td>
                <td><p class="h5">Cantidad</p></td>
                <td></td>
            </thead>
    `
    $('#productos').html(cont)
    //Inicializa la tabla de totales
    var cab_tot = `
        <table class="table table-hover">
            <thead>
                <td><p class="h5">Subtotal</p></td>
                <td><p class="h5">IVA</p></td>
                <td><p class="h5">Total a pagar</p></td>
                <td></td>
            </thead>
    `
    $('#totales').html(cab_tot)
    

    function cargarDatos() {//Función que pinta los datos en la parte inferior
        const buscar = $('#buscador').val()//Tomamos lo que halla en el campo de buscar
        $.ajax({//Hacemos una petición POST al servidor PHP
            url: 'controlador/cproducto.php',
            type: 'POST',
            data: {
                operacion: 'mosprodID',
                buscar: buscar
            },
            success: function (res) {//Si arroja un resultado Se muestra aquí
                if (res != 'null') {
                    var cont = `
                        <table class="table table-striped">
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
                                   <b>bodega</b> ${u.bodega}
                               </td>
                               <td>
                                    <button class="btn btn-danger mr-2 agregar">Agregar</button>
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
    $(document).on('click', '.agregar', function () {//Función para que el formulario elimine
        let tr = $(this)[0].parentElement.parentElement//Llamamos al elemento padre del campo HTML
        let id = $(tr).attr('idprod')//Buscamos el atributo "idprod" dentro de la etiqueta padre
        let datos = 'idprod=' + id + '&operacion=AddProd'//La operacion será Añadir producto en el servidor
        //console.log(datos)
        $.post('controlador/cfact.php',datos,function (res) {
            ///console.log(res)
        })
        listar()
        
    })

    $(document).on('click', '.quitar', function () {//Función para que el formulario elimine
        let tr = $(this)[0].parentElement.parentElement//Llamamos al elemento padre del campo HTML
        let id = $(tr).attr('idprod')//Buscamos el atributo "idprod" dentro de la etiqueta padre
        let precio = $(tr).attr('precio')//Buscamos el atributo "precio" dentro de la etiqueta padre
        subtotal -= parseInt(precio)
        $(tr).remove()
        datos = 'operacion=QuitProd&idprod='+id
        $.post('controlador/cfact.php',datos,function(res){
            console.log(res)
        })
        totales(subtotal)
    })

    function totales(subtotal) {
        let iva = parseInt(subtotal * 0.19)
        let total = parseInt(subtotal + iva)
        tot = `
            <tr>
                <td><p class="h5">${subtotal}</p></td>
                <td><p class="h5">${iva}</p></td>
                <td><p class="h5">${total}</p></td>
            </tr>
        `
        datos = 'subtotal='+subtotal+'&iva='+iva+'&total='+total+'&operacion=UpdFact'
        $.post('controlador/cfact.php',datos,function(res){
            console.log(res)
        })
        $('#totales').html(cab_tot + tot)
    }
    $('#buscador').on('input', cargarDatos)
    $('#addFact').on('click',inifact)

    function inifact(){
        datos = 'operacion=AddFact'
        if ($('#idf').length != 0) datos += '&idfact=' + $('#id').val()
        console.log(datos)
        $.post('controlador/cfact.php',datos,function(res){
            console.log(res)
            listar()
        })
    }

    function listar() {
        datos = 'operacion=AddProduct'
        $.post('controlador/cfact.php', datos, function (res) {
            const reg = JSON.parse(res)//Convertimos el resultado en JSON   
            reg.forEach(r => {
                cont += `<tr idprod="${r.idprod}" precio="${r.precio}">`
                cont += `<td><p class="ltp2">${r.nombre}</p></td>`
                cont += `<td><b>${r.precio}</b></td>`
                subtotal += parseInt(r.precio)
                cont += `<td><b>${r.cant} paquetes`
                if (r.unid != 0) cont += ` x${r.unid} unidades`
                cont += `</b></td>`
                cont += `<td><button class="btn btn-danger quitar">Quitar</button></td>`
                cont += `</tr>`
                totales(subtotal)
            });

            $('#productos').html(cont)
        })
    }
})