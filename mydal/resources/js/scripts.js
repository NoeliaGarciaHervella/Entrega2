/*
Noelia García Hervella
Inés Prieto González
Pablo Gallero Portela
*/


$(document).ready(function() {
  setTimeout(function() {
      $(".alert-success").alert('close');
      $(".alert-danger").alert('close');
  }, 4000);
});

/* FUNCION QUE MUESTRA EL MENU DE LAS CARPETAS*/
function mostrarCarpeta(event,id){
    
  var opcioncarpeta = document.getElementById("opcionescarpeta"+id);
  var opcionescarpeta = document.getElementsByClassName("opcionescarpeta");
  var opcionesfichero = document.getElementsByClassName("opcionesfichero");

  recorrerIf(opcioncarpeta,opcionescarpeta); //Ponemos el display a none en todas las carpetas menos la seleccionada
  recorrer(opcionesfichero); //Ponemos el display a none en todos los ficheros 
  cambiar(event, opcioncarpeta); //Cambiamos el display de la carpeta seleccionada

};


/* FUNCION QUE MUESTRA EL MENU DE LOS FICHEROS */
function mostrarFichero(event,id){

  var opcionfichero = document.getElementById("opcionesfichero"+id);
  var opcionesfichero = document.getElementsByClassName("opcionesfichero");
  var opcionescarpeta = document.getElementsByClassName("opcionescarpeta");

  recorrerIf(opcionfichero,opcionesfichero); //Ponemos el display a none en otdas los ficheros menos el seleccionado
  recorrer(opcionescarpeta); //Ponemos el display a none en todas las carpetas
  cambiar(event, opcionfichero); //Cambiamos el display del fichero seleccionado
  

};

//Pone display none a todas las carpetas o ficheros excepto el que estamos seleccionando
function recorrerIf(op, opciones){
  for( i= 0; i<opciones.length; i++){
    if(op != opciones[i]){
      opciones[i].style.display = "none";
      
    }
  }
}

//Pone display none a todas las carpetas o ficheros
function recorrer(opciones){
  for( i= 0; i<opciones.length; i++){
    opciones[i].style.display = "none";
  }
}

//Cambia el display de la carpeta o el fichero

function cambiar(event, op){

  if(event.button == 2 && (op.style.display=="none" || op.style.display == "") ){
    op.style.display = "block";
  }else{
    op.style.display = "none";
  }

}

/* FUNCION QUE ESCONDE EL MENU TANTO DE LOS FICHEROS COMO DE LAS CARPETAS */
function quitar(){
var opcionescarpeta = document.getElementsByClassName("opcionescarpeta");
/*for( i= 0; i<opcionescarpeta.length; i++){  
  opcionescarpeta[i].style.display = "none"; 
}*/

recorrer(opcionescarpeta);

var opcionesfichero = document.getElementsByClassName("opcionesfichero");
  /*for( i= 0; i<opcionesfichero.length; i++){
      opcionesfichero[i].style.display = "none";
  }*/
recorrer(opcionesfichero);

};



$(function(){
  $(".carpeta").click(function(){
    id = $(this).attr("id")
    window.location.href = "index.php?controller=folders&action=showall&idFather="+id
  })
})


$(function(){
  $(".clickEliminarCarpeta").click(function(){
    
    id2 = $(this).parent().parent().parent().parent().siblings().attr('id');
    $(".eliminarCarpeta").attr('data-id',id2)
    $(".eliminarCarpeta").click(function(){
      id= $(this).attr('data-id');
      window.location.href = "index.php?controller=folders&action=deleteFolder&idFolder="+id
    })
  })
})



$(function(){
  $(".clickEliminarFichero").click(function(){
    
    id2 = $(this).parent().parent().parent().parent().siblings().attr('id');
    
    $(".eliminarFichero").attr('data-id',id2)
    $(".eliminarFichero").click(function(){
      id= $(this).attr('data-id');
      window.location.href = "index.php?controller=files&action=deleteFile&idFile="+id
    })
  })
})

$(function(){
  $(".clickCompartirFichero").click(function(){
    
    id2 = $(this).parent().parent().parent().parent().siblings().attr('id');
    id3 = $(this).attr('id');
    var nodo = document.getElementById("enlace");
    nodo.innerHTML ="localhost/mydal/index.php?controller=files&action=shareFile&idFile="+id3;
    document.getElementById("rutaCompartirFichero").appendChild(nodo);    
    
    $(".compartirFichero").attr('data-id',id2)
    $(".compartirFichero").click(function(){
      id= $(this).attr('data-id');
      window.location.href = "index.php?controller=files&action=checkShareFile&idFile="+id
      //http://localhost/mydal/index.php?controller=folders&action=showall
    })

  })
})



