const formulario=document.getElementById("formVehiculo");

const placa=document.getElementById("placa");
const marca=document.getElementById("marca");
const tipo=document.getElementById("tipo");
const anio=document.getElementById("anio");

const errorPlaca=document.getElementById("errorPlaca");
const errorMarca=document.getElementById("errorMarca");
const errorTipo=document.getElementById("errorTipo");
const errorAnio=document.getElementById("errorAnio");

const tabla=document.getElementById("tablaVehiculos");
const contador=document.getElementById("contador");
const limpiar=document.getElementById("limpiarTabla");

let total=0;

function limpiarErrores(){

    errorPlaca.textContent="";
    errorMarca.textContent="";
    errorTipo.textContent="";
    errorAnio.textContent="";

}

formulario.addEventListener("submit",function(e){

    e.preventDefault();

    limpiarErrores();

    let valido=true;

    let regex=/^[A-Z]{3}-\d{4}$/;

    if(!regex.test(placa.value.trim())){

        errorPlaca.textContent="Formato válido: ABC-1234";
        valido=false;

    }

    if(marca.value.trim().length<3){

        errorMarca.textContent="Ingrese mínimo 3 caracteres";
        valido=false;

    }

    if(tipo.value===""){

        errorTipo.textContent="Seleccione un tipo";
        valido=false;

    }

    const anioActual=new Date().getFullYear();

    if(anio.value==="" || anio.value<2015 || anio.value>anioActual){

        errorAnio.textContent="Año inválido";
        valido=false;

    }

    if(!valido){

        return;

    }

    const fila=document.createElement("tr");

    fila.innerHTML=`

        <td>${placa.value}</td>
        <td>${marca.value}</td>
        <td>${tipo.value}</td>
        <td>${anio.value}</td>

    `;

    tabla.appendChild(fila);

    total++; //total = total + 1

    contador.textContent=total;

    formulario.reset();

});

limpiar.addEventListener("click",function(){

    if(confirm("¿Desea eliminar todos los registros?")){

        tabla.innerHTML="";

        total=0;

        contador.textContent=0;

    }

});