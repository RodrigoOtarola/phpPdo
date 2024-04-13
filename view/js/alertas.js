//Seleccionar formularios
const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    //Para detener la ejecución del formulario
    e.preventDefault();

    //Obtenemos los datos del formulario
    let data = new FormData(this);

    //Enviamos los datos por post
    let methos = this.getAttribute("method");

}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener('submit', enviar_formulario_ajax);
});

function alertas_ajax(alerta) {
    if (alerta.Alerta === "simple") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar',

        });
    } else if (alerta.Alerta === "recargar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar',
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    } else if (alerta.Alerta === "limpiar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar',
        }).then((result) => {
            if (result.isConfirmed) {
                //Para limpiar formulario
                document.querySelector('.FormularioAjax').reset();
            }
        });
    } else if (alerta.Alerta === "redireccionar") {
        window.location.href=alerta.URL;
    }
}