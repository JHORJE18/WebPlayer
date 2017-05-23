<html>
<head>
    <title>Formulario para cargar cancion</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="mdl-grid mdl-color--white">
      <div class="mdl-cell mdl-cell--6-col mdl-color--white" style="margin-left: auto; margin-right: auto;">
        <form action="index.php" method="GET">
            <h1>Inserta los siguientes datos</h1>

                <h4>Selecciona una canción</h4>
                <hr>
                <?php
                $directorio = 'MUSICA';
                $ficheros  = scandir($directorio);

                foreach ($ficheros as &$valor) {
                    if ($valor == "." || $valor == ".."){

                    } else {
                        echo '<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="musica-'.$valor.'">
                            <input type="radio" id="musica-'.$valor.'" class="mdl-radio__button" name="enlace" value="'.$valor.'">
                            <span class="mdl-radio__label">'.$valor.'</span></label><br>';
                    }
                }
                unset($valor);
                ?>
                <hr>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" name="artista" type="text" id="artista">
                        <label class="mdl-textfield__label" for="artista">Artista</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" name="foto" type="url" id="foto">
                        <label class="mdl-textfield__label" for="foto">URL Foto</label>
                    </div>
                <hr>
        
            <div class="mdl-cell--2-col" style="padding:10px">
                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit">Cargar canción</button>
                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" type="reset">Borrar Selección</button>    
            </div>
            
        </form>
      </div>
</div>

</body>
</html>