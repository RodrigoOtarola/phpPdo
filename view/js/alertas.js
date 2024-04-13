//Seleccionar formularios

const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    //Para detener la ejecución del formulario
    e.preventDefault();

    //Obtenemos los datos del formulario
    let data = new FormData(this);

    //Enviamos los datos por post
    let method = this.getAttribute("method");

    //ACtion del formulario
    let action = this.getAttribute("action");

    //Tipo de formulario, save es guardar
    let tipo = this.getAttribute("data-form");

    let encabezado = new Headers();

    let config = {
        method: method,
        headers: encabezado,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }

    let texto_alerta;

    if (tipo === "save") {
        texto_alerta = "Los datos quedaran guardados en el sistema";
    } else if (tipo === "delete") {
        texto_alerta = "Los datos seran eliminados del sistema";
    } else if (tipo === "update") {
        texto_alerta = "Los datos fueron actualizados";
    } else if (tipo === "search") {
        texto_alerta = "Se elimina el termino de busqueda, escribe uno nuevo";
    } else if (tipo === "loans") {
        texto_alerta = "Desea remover los datos para prestamos";
    } else {
        texto_alerta = "Quieres realizar lo operacion solicitada"
    }

    Swal.fire({
        title: '¿Estas seguro?',
        text: texto_alerta,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(action, config)
                //Parseamos respuesta en formato Json
                .then(respuesta=> respuesta.json())
                .then(respuesta => {
                   return alertas_ajax(respuesta);
                });
        }
    });


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
        window.location.href = alerta.URL;
    }
}