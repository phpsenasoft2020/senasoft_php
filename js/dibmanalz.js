var movimientos = new Array();
var pulsado;

function limpiarLienzo(){
    context.clearRect(0, 0, canvas.width, canvas.height);
    canvas.width=canvas.width;
}

function comenzar() {
    canvas = document.getElementById('canvas');
    context = canvas.getContext("2d");

        $('#canvas').mousedown(function(e){
          pulsado = true;
          movimientos.push([e.pageX - this.offsetLeft,
              e.pageY - this.offsetTop,
              false]);
          repinta();
        });

        $('#canvas').mousemove(function(e){
          if(pulsado){
              movimientos.push([e.pageX - this.offsetLeft,
                  e.pageY - this.offsetTop,
                  true]);
            repinta();
          }
        });

        $('#canvas').mouseup(function(e){
          pulsado = false;
        });

        $('#canvas').mouseleave(function(e){
          pulsado = false;
        });
        repinta();
}
function repinta() {
      canvas.width = canvas.width; // Limpia el canvas

      context.strokeStyle = "#000000";
      context.lineJoin = "round";
      context.lineWidth = 4;
     
      for(var i=0; i < movimientos.length; i++)
      {     
        context.beginPath();
        if(movimientos[i][2] && i){
          context.moveTo(movimientos[i-1][0], movimientos[i-1][1]);
         }else{
          context.moveTo(movimientos[i][0], movimientos[i][1]);
         }
         context.lineTo(movimientos[i][0], movimientos[i][1]);
         context.closePath();
         context.stroke();
      }
}

function upload(nomarc) {
    $.post('upload-imagen.php',
        {
        img : canvas.toDataURL(),
        nom : getParameterByName('norad'),
        id : getParameterByName('idusu'),
        fi : getParameterByName('fir')
        },
        function(data) { 
//        $('#imagen').attr('src', 'uploads/fir_' + nom + '.png?timestamp=' + new Date().getTime());
    if(getParameterByName('fir')==11){
      $('#imagen').attr('src', 'uploads/pla_' + getParameterByName('idusu') + '.png?timestamp=' + new Date().getTime());
    }
    if(getParameterByName('fir')==12){
      $('#imagen').attr('src', 'uploads/vis_' + getParameterByName('idusu') + '.png?timestamp=' + new Date().getTime());
    }
    else{
      $('#imagen').attr('src', 'uploads/fir_' + getParameterByName('norad') + '.png?timestamp=' + new Date().getTime());
    }
        });
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}