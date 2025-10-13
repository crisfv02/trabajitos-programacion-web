<?php
   
    if ( count($_REQUEST) > 0 ){

        $aprobados = 0;
        $reprobados = 0;
        $alumnos_np = 0;
        $suma_de_calificaciones = 0;
        $alumnos_con_calificacion = 0; 
        $mejor_calificacion = null; 
        $peor_calificacion = null; 

        foreach($_REQUEST as $llave => $valor_calificacion) {
            if ($valor_calificacion == "NP") {
                $alumnos_np = $alumnos_np + 1; 
            }
            else {
                $calificacion_numerica = (int)$valor_calificacion;
                $suma_de_calificaciones = $suma_de_calificaciones + $calificacion_numerica;
                $alumnos_con_calificacion = $alumnos_con_calificacion + 1;

                if ($calificacion_numerica >= 6) {
                    $aprobados = $aprobados + 1;
                } else {
                    $reprobados = $reprobados + 1;
                }
                if ($mejor_calificacion === null || $calificacion_numerica > $mejor_calificacion) {
                    $mejor_calificacion = $calificacion_numerica;
                }
                if ($peor_calificacion === null || $calificacion_numerica < $peor_calificacion) {
                    $peor_calificacion = $calificacion_numerica;
                }
            }
        }
        echo "<h1>Estadísticas del Grupo</h1>";
        if ($alumnos_con_calificacion > 0) {
            $porcentaje_aprobados = ($aprobados / $alumnos_con_calificacion) * 100;
            $porcentaje_reprobados = ($reprobados / $alumnos_con_calificacion) * 100;
            $promedio_general = $suma_de_calificaciones / $alumnos_con_calificacion;

            echo "<b>Porcentaje de aprobados:</b> " . $porcentaje_aprobados . "%<br>";
            echo "<b>Porcentaje de reprobados:</b> " . $porcentaje_reprobados . "%<br>";
            echo "<b>Aprovechamiento general (promedio):</b> " . $promedio_general . "<br>";
            echo "<b>Mejor calificación:</b> " . $mejor_calificacion . "<br>";
            echo "<b>Peor calificación:</b> " . $peor_calificacion . "<br>";

        } else {
            echo "No se registraron calificaciones numéricas para poder calcular las estadísticas.<br>";
        }
        echo "<b>Alumnos que no presentaron (NP):</b> " . $alumnos_np . "<br>";
    } else {
        echo "Acceso no válido";
    }
?>
