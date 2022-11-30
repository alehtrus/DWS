<html>
<head>
    <title>Esto es el titulo</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8"> 
</head>
<body>
    <div class="contenedor">
        <div class="primera_caja">
            <a href="index.php">INICIO</a>
            <a href="pagina1.html">Primera página</a>
            <a href="pagina2.html">Segunda página</a>
        </div>
        <div class="segunda_caja">

            <div class="primera_columna">
                <ul>
                    <li><a href="0_hola_mundo.php">0. Hola Mundo PHP</a></li>
                    <li><a href="1_hola_mundo_comentarios.php">1. Hola Mundo con comentarios</a></li>
                    <li><a href="2_variables_y_tipos.php">2. Variables y tipos</a></li>
                    <li><a href="3_arrays_bucles.php">3. Arrays y bucles</a></li>
                    <li><a href="4_constantes.php">4. Constantes</a></li>
                </ul>
            </div>
            <div class="segunda_columna">
                <p>
                    <?php
                        define("MAX_VALUE",10);

                        echo "El valor de la constante MAX_VALUE es: " .MAX_VALUE. "<br>";

                        const MIN_VALUE = 1;

                        echo "El valor de la constante MIN_VALUE es: " .MIN_VALUE. "<br>";

                        /*
                        Abre la siguiente página y lee sobre cuando podemos usar 'define'
                        o cuando 'const'.
                        https://www.php.net/manual/en/language.constants.syntax.php
                        */

                    ?>
                </p>
            </div>
            <div class="tercera_columna">asssa</div>
        </div>
        <div class="tercera_caja">ccc</div>
        <footer>Pie de pagina</footer>
    </div>
</body>
</html>

