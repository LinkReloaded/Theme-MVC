<?

/* Configuración del módulo de CRUD */

/*Login*/

/* Tabla de "index" */
$globales[$_GET[nomParamModulo]]['index']['tablaBd'] = "simulador_simulaciones";

/* Configuración de campos de "index" */
$globales[$_GET[nomParamModulo]]['index']['arregloMaestro'] = array(
    "nomSeccion" => "Suzuki Autos",
    "campos" =>
    array(
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "id",
            "reporte" => "Id",
            "reporteTabla" => "Id"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "fecha",
            "reporte" => "fechahora",
            "reporteTabla" => "Fecha",
            "tipoFiltro" => "rangoNormal2",
            "idFiltro" => "fecha",
            "nomFiltro" => "FECHA",
            "tituloFiltro" => "SELECCIONE FECHAS",
            "tituloFiltro2" => ""
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "simulador_clientes_rut",
            "reporte" => "rut",
            "reporteTabla" => "Rut",
            "tipoFiltro" => "normal2",
            "idFiltro" => "rut",
            "nomFiltro" => "RUT",
            "tituloFiltro" => "INGRESE RUT"
        ),
//                    array(
//                        "tabla" => "simulador_clientes",
//                        "bd" => "sexo",
//                        "reporte" => "Género",
//                        "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
//                        "bdFk" => "simulador_clientes_rut",
//                        "pkFk" => "rut"
//                    ),
        array(
            "tabla" => "simulador_clientes",
            "bd" => "nombre",
            "reporte" => "nombres",
            "reporteTabla" => "Nombres",
            "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bdFk" => "simulador_clientes_rut",
            "pkFk" => "rut"
        ),
        array(
            "tabla" => "simulador_clientes",
            "bd" => "apellido",
            "reporte" => "apellidos",
            "reporteTabla" => "Apellidos",
            "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bdFk" => "simulador_clientes_rut",
            "pkFk" => "rut"
        ),
        array(
            "tabla" => "simulador_clientes",
            "bd" => "fono",
            "reporte" => "fono",
            "reporteTabla" => "Fono",
            "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bdFk" => "simulador_clientes_rut",
            "pkFk" => "rut"
        ),
        array(
            "tabla" => "simulador_clientes",
            "bd" => "mail",
            "reporte" => "mail",
            "reporteTabla" => "Mail",
            "tipoFiltro" => "normal2",
            "idFiltro" => "email",
            "nomFiltro" => "EMAIL",
            "tituloFiltro" => "INGRESE EMAIL",
            "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bdFk" => "simulador_clientes_rut",
            "pkFk" => "rut"
        ),
        array(
            "tabla" => "simulador_clientes",
            "bd" => "calle",
            "reporte" => "dirección",
            "reporteTabla" => "Dirección",
            "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bdFk" => "simulador_clientes_rut",
            "pkFk" => "rut"
        ),
//                    array(
//                        "tabla" => "simulador_clientes",
//                        "bd" => "ciudad",
//                        "reporte" => "Ciudad",
//                        "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
//                        "bdFk" => "simulador_clientes_rut",
//                        "pkFk" => "rut"
//                    ),
        array(
            "tabla" => "simulador_clientes",
            "bd" => "comuna",
            "reporte" => "comuna",
            "reporteTabla" => "Comuna",
            "tablaFk" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bdFk" => "simulador_clientes_rut",
            "pkFk" => "rut"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "origen",
            "reporte" => "Origen",
//                        "reporteTabla" => "Origen"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "origen2",
            "reporte" => "Origen2",
            "reporteTabla" => "Origen2"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "marca",
            "reporte" => "marca"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "modelo",
            "reporte" => "modelo"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "version",
            "reporte" => "version"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "codigoVersion",
            "reporte" => "Código Version"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "versionColor",
            "reporte" => "color"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "accesorios",
            "reporte" => "accesorios"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "precioVersion",
            "reporte" => "precio"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "partePagoMarca",
            "reporte" => "marcapartedepago"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "partePagoModelo",
            "reporte" => "modelopartedepago"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "partePagoPatente",
            "reporte" => "patente"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "partePagoAnio",
            "reporte" => "Anio"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['index']['tablaBd'],
            "bd" => "partePagoValor",
            "reporte" => "valor"
        )
    )
);

/*Tabla de "Usuarios"*/
$globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'] = "backend_usuarios";

/* Configuración de campos de "Usuarios" */
$globales[$_GET[nomParamModulo]]['usuarios']['arregloMaestro'] = array(
    "nomSeccion" => "usuarios",
    "campos" =>
    array(
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "id",
            "reporte" => "Id",
            "reporteTabla" => "Id"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "nombres",
            "reporte" => "Nombre",
            "reporteTabla" => "Nombre",
            "tipoFiltro" => "normal2",
            "idFiltro" => "nombre",
            "nomFiltro" => "Nombre",
            "tituloFiltro" => "INGRESE NOMBRE"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "apellidos",
            "reporte" => "Apellido",
            "reporteTabla" => "Apellido",
            "tipoFiltro" => "normal2",
            "idFiltro" => "apellido",
            "nomFiltro" => "Apellido",
            "tituloFiltro" => "INGRESE APELLIDO"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "empresa",
            "reporte" => "Empresa",
            "reporteTabla" => "Empresa"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "marcasAsignadas",
            "reporte" => "Marcas a las que tiene acceso",
            "reporteTabla" => "Marcas a las que tiene acceso"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "email",
            "reporte" => "E-mail",
            "reporteTabla" => "E-mail",
            "tipoFiltro" => "normal2",
            "idFiltro" => "email",
            "nomFiltro" => "E-Mail",
            "tituloFiltro" => "INGRESE E-MAIL"
        ),
        array(
            "tabla" => $globales[$_GET[nomParamModulo]]['usuarios']['tablaBd'],
            "bd" => "tipoUsuario",
//                            "reporte" => "Nombre",
//                            "reporteTabla" => "Nombre",
            "tipoFiltro" => "normal",
            "idFiltro" => "tipoUsuario",
            "nomFiltro" => "Tipo Usuario",
            "tituloFiltro" => "SELECCIONE TIPO DE USUARIO"
        ),
        array(
            "reporteTabla" => "editar"
        ),
        array(
            "reporteTabla" => "borrar"
        )
    )
);
?>