<?php

class Pelicula
{

    private function init($id, $titulo, $año, $duracion, $sinopsis, $imagen, $votos, $idCategoria)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->año = $año;
        $this->duracion = $duracion;
        $this->sinopsis = $sinopsis;
        $this->imagen = $imagen;
        $this->votos = $votos;
        $this->idCategoria = $idCategoria;
    }

    function __construct()
    {
    }

    function leerPeliculas()
    {
        require('conexionBD.php');

        $id_categoria = $_GET['idc'];

        if (isset($_GET['orden'])) {
            $orden = $_GET['orden'];
        } else {
            $orden = '';
        }


        switch ($orden) {
            case 1:
                $orden = "order by votos";
                break;
            case 2:
                $orden = "order by votos desc";
                break;
            case 3:
                $orden = "order by titulo";
                break;
            case 4:
                $orden = "order by titulo desc";
                break;
            default:
                $orden = '';
        }

        $sanitized_categoria_id = mysqli_real_escape_string($conexion, $id_categoria);

        $consulta = "SELECT id, titulo, año, duracion_min, sinopsis, imagen, votos, idCategoria FROM T_PELICULAS WHERE idCategoria=" . $sanitized_categoria_id . " " . $orden . ";";
        $resultado = mysqli_query($conexion, $consulta);

        $peliculas = [];
        $contador = 0;

        if (!$resultado) {
            $mensaje = 'Consulta inválida: ' . mysqli_errno($conexion) . '\n';
            $mensaje .= 'Consulta realizada: ' . $consulta;
            die($mensaje);
        } else {
            if (($resultado->num_rows) > 0) {
                while ($registro = mysqli_fetch_assoc($resultado)) {

                    $peli = new Pelicula();
                    $peli->init($registro['id'], $registro['titulo'], $registro['año'], $registro['duracion_min'], $registro['sinopsis'], $registro['imagen'], $registro['votos'], $registro['idCategoria']);

                    $peliculas[$contador] = $peli;
                    $contador++;
                }
            } else {
                header('Location: error.html');
            }
        }

        return $peliculas;
    }

    function pintarPeliculas($peliculas)
    {

        foreach ($peliculas as $pelicula) {
            echo "<div class='contenido'>";
            echo "<div class='pelicula'>";
            echo "<div class='cabeceraPeli'>";
            echo '<h2>' . $pelicula->titulo . '</h2>';
            echo '<p>Votos: ' . $pelicula->votos . '</p>';
            echo '</div>';

            echo "<div class='centPeli'>";
            echo "<img class='imagenPeli' src='fotos/" . $pelicula->imagen . "' alt='imagen de la pelicula'>";
            echo '<div class="descripcion"><p>' . $pelicula->sinopsis . '</p></div>';
            echo '</div>';

            echo "<div class='piePeli'>";
            echo '<p>Duración: ' . $pelicula->duracion . ' min</p>';
            echo "<p id='enlace'>Ver  <a href='verFicha.php?idp=" . $pelicula->id . "&idc=" . $pelicula->idCategoria . "'>ficha de pelicula</a></p>";
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<br>';
        }
    }

    function leerFichaPelicula()
    {
        require('conexionBD.php');

        $idPelicula = $_GET['idp'];
        $sanitized_categoria_id = mysqli_real_escape_string($conexion, $idPelicula);
        $consulta = "SELECT DISTINCT 
        p.titulo,p.sinopsis,p.duracion_min,p.votos,p.imagen, a.nombre as actores, d.nombre as directores
            FROM
        T_PELICULAS AS p
            LEFT JOIN
        T_ACTORES_PELICULAS AS ap ON p.id = ap.idPelicula
            LEFT JOIN
        T_ACTORES AS a ON ap.idActores = a.id
            LEFT JOIN
        T_DIRECTORES_PELICULAS AS dp ON dp.idPelicula = p.id
            LEFT JOIN
        T_DIRECTORES AS d ON d.id = dp.idPelicula WHERE p.id='" . $sanitized_categoria_id . "';";
        $resultado = mysqli_query($conexion, $consulta);

        if (!$resultado) {
            $mensaje = 'Consulta inválida: ' . mysqli_errno($conexion) . '\n';
            $mensaje .= 'Consulta realizada: ' . $consulta;
            die($mensaje);
        } else {
            if (($resultado->num_rows) > 0) {

                $registro = mysqli_fetch_assoc($resultado);

                echo "<div class='pelicula-Ficha'>";
                echo "<div class='cabeceraPeli-Ficha'>";
                echo '<h2>' . $registro['titulo'] . '</h2>';

                echo '</div>';
                echo "<div class='dimg-Ficha'><img class='imagenPeli-Ficha' src='fotos/" . $registro['imagen'] . "' alt='imagen de la pelicula'></div>";
                echo '<p class="sinopsis">' . $registro['sinopsis'] . '</p>';
                echo "<div class='centPeli-Ficha'>";
                echo '<p><span>Director/es:</span> ' . $registro['directores'] . '</p>';
                $actores = ' ';
                while ($registro2 = mysqli_fetch_assoc($resultado)) {
                    $actores .= $registro2['actores'] . ', ';
                }
                echo '<p><span>Actores:</span> ' . $actores . '</p>';
                echo "</div>";
                echo "<div class='piePeli-Ficha'>";
                echo '<p><span>Duración:</span> ' . $registro['duracion_min'] . ' min</p>';
                echo '<p id="voto"><span>Votos:</span> ' . $registro['votos'] . '</p>';
                echo '</div>';
                echo '</div>';

                echo "
                    <br>
                        <form action='votar.php' method='post'>
                            <a class='volver boton' href='cartelera.php?idc= " . $_GET['idc'] . "'>Volver</a>
                            <input class='boton' id='enviar' type='submit' value='Votar'>
                            <input type='hidden' name='idp' value= " . $_GET['idp'] .">
                        </form>
                ";
            } else {
                header('Location: error.html');
            }
        }
    }
/*
    function refrescar()
    {
        session_start();
        if (!isset($_SESSION['already_refreshed'])) {
            header("Refresh: 5");
            $_SESSION['already_refreshed'] = true;
        }
    }
*/
}
