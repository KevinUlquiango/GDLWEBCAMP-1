<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title>Calendario</title>
    <main class="contenido-main" id="calendario">

        <?php
        include_once 'includes/templates/header.php';
        try{
            include_once 'includes/funciones/bd_conexion.php';
            $sql = "SELECT evento_id, nombre_evento, fecha_evento , hora_evento,cat_evento, icono, nombre_invitado, apellido_invitado ";
             $sql .= " FROM eventos" ;
             $sql .= " INNER JOIN categoria_evento ";
             $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
             $sql .= " INNER JOIN invitados ";
             $sql .= " ON eventos.id_inv = invitados.invitado_id";
             $sql .= " ORDER BY evento_id ";
            $resultado = $conn->query($sql);
        }catch(\Exception $e){
            echo $e->getMessage();
        }
        ?>
        <section class="seccion contenedor">
            <h2>Calendario de eventos</h2>
            <div class="calendario">

                <?php
                $calendario = array();

                while ($eventos = $resultado->fetch_assoc()) {

                    //  obtiene la fecha del efecto
                    $fecha = $eventos['fecha_evento'];
                    $evento = array(
                        'titulo' => $eventos['nombre_evento'],
                        'fecha' => $eventos['fecha_evento'],
                        'hora' => $eventos['hora_evento'],
                        'categoria' => $eventos['cat_evento'],
                        'icono' => $eventos['icono'],
                        'invitado' => $eventos['nombre_invitado'] . " " . $eventos['apellido_invitado']
                    );
                    $calendario[$fecha][] = $evento;  // agrupa por fecha 
                } ?>
                <?php
                // imprime todos los eventos
                foreach ($calendario as $dia => $lista_eventos) { ?>
                    <h3>
                        <i class="fa fa-calendar"></i>

                        <?php
                        // UNIX
                        setlocale(LC_TIME, 'es_ES.UTF-8');
                        // WINDOWS
                        setlocale(LC_TIME, 'spanish.UTF-8');
                        //Traducir los d??as de la semana para solicionar el error al obtener los dias desde heroku
                        $dia_actual = strftime("%A", strtotime($dia));
                        if($dia_actual === 'Monday' || $dia_actual === 'Lunes'){
                            $dia_espa??ol = 'Lunes';
                        }else if($dia_actual === 'Tuesday' || $dia_actual === 'martes'){
                            $dia_espa??ol = 'Martes';
                        }else if($dia_actual === 'Wednesday' || $dia_actual === 'mi??rcoles'){
                            $dia_espa??ol = 'Mi??rcoles';
                        }else if($dia_actual === 'Thursday' || $dia_actual === 'jueves'){
                            $dia_espa??ol = 'Jueves';
                        }else if($dia_actual === 'Friday' || $dia_actual === 'viernes'){
                            $dia_espa??ol = 'Viernes';
                        }else if($dia_actual === 'Saturday' || $dia_actual === 's??bado'){
                            $dia_espa??ol = 'S??bado';
                        }else if($dia_actual === 'Sunday' || $dia_actual === 'domingo'){
                            $dia_espa??ol = 'Domingo';
                        }
                        //imprimimos el dia de la semana
                        echo ' ' . $dia_espa??ol;
                        echo strftime(", %d de ", strtotime($dia));

                        //traducimos los meses
                        $mes = strftime("%B", strtotime($dia));
                        if($mes === 'January' || $mes === 'enero'){
                            $mes_espa??ol = 'Enero';
                        }else if($mes === 'february' || $mes === 'febrero'){
                            $mes_espa??ol = 'Febrero';
                        }else if($mes === 'March' || $mes === 'marzo'){
                            $mes_espa??ol = 'Marzo';
                        }else if($mes === 'April' || $mes === 'abril'){
                            $mes_espa??ol = 'Abril';
                        }else if($mes === 'May' || $mes === 'mayo'){
                            $mes_espa??ol = 'Mayo';
                        }else if($mes === 'June' || $mes === 'june'){
                            $mes_espa??ol = 'Junio';
                        }else if($mes === 'July' || $mes === 'julio'){
                            $mes_espa??ol = 'Julio';
                        }else if($mes === 'August' || $mes === 'agosto'){
                            $mes_espa??ol = 'Agosto';
                        }else if($mes === 'September' || $mes === 'septiembre'){
                            $mes_espa??ol = 'Septiembre';
                        }else if($mes === 'October' || $mes === 'octubre'){
                            $mes_espa??ol = 'Octubre';
                        }else if($mes === 'November' || $mes === 'noviembre'){
                            $mes_espa??ol = 'Noviembre';
                        }else if($mes === 'December' || $mes === 'diciembre'){
                            $mes_espa??ol = 'Diciembre';
                        }
                        echo $mes_espa??ol;
                        echo strftime(" del %Y", strtotime($dia)); ?>
                    </h3>
                    <?php foreach ($lista_eventos as $evento) { ?>
                        <div class="dia">
                            <p class="titulo"><?php echo $evento['titulo']; ?></p>
                            <p class="hora"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                <?php
                                // Formatear fecha del evento
                                $fecha_formateada = date('d-m-Y',strtotime($evento['fecha']));
                                 echo  $fecha_formateada . "  " . $evento['hora'] . ' hrs'; ?>
                            </p>
                            <p>
                                <i class="<?php echo $evento['icono']; ?>" aria-hidden="true"></i>
                                <?php echo $evento['categoria']; ?>
                            </p>
                            <p><i class="fa fa-user" aria-hidden="true"></i>
                                <?php echo $evento['invitado']; ?>
                            </p>
                        </div>
                    <?php } // fin foreach eventos
                    ?>
                <?php } // fin foreach de dias 
                ?>



            </div>
            <?php $conn->close(); ?>
        </section>
        <div class="s clearfix"></div>
        <?php include_once 'includes/templates/footer.php'; ?>