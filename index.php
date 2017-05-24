<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sound Coffee</title>
  <?php 

  //Incluimos datos conex con BBDD
  include 'conexion.php';

  		if(isset($_GET['id'])){
				$id = $_GET['id'];

			$sql = "SELECT * FROM `cancion` WHERE ID = '$id'";
			$result= $conexion -> query($sql);
			if ($result){
				$song = $result->fetch_array();

				//Asignacion valores
				$titulo = $song[4];
				$enlace = $song[7];
				
				//Obtener artista
				$sqlArtista = "SELECT * FROM `usuario` WHERE ID = '$song[1]'";
				$resultArtista =$conexion->query($sqlArtista);
				if ($resultArtista){
					$autor= $resultArtista->fetch_array();
					$artista = $autor[1];
				} else {
					$artista = "Desconocido";
				}

				//Obtener artista
				$sqlAlbum = "SELECT * FROM `album` WHERE `ID-ALBUM` = '$song[2]'";
				$resultAlbum =$conexion->query($sqlAlbum);
				if ($resultAlbum){
					$album= $resultAlbum->fetch_array();
					$foto = $album[5];
				} else {
					$artista = "Desconocido";
				}


			} else {
				echo 'Error al conectar loco';
			}

			//Descargar cancion
			if ($_GET['descarga'] != null){

				//Descarga Cancion
				if ($_GET['descarga'] == "song" && $_GET['enlace'] != null){
					header("Content-disposition: attachment; filename=".$enlace);
					header("Content-type: audio/mpeg");
					readfile($enlace);
				}

				//Descarga App
				if ($_GET['descarga'] == "app"){
					header("Content-disposition: attachment; filename=".$enlace);
					header("Content-type: application/zip");
					readfile("/App");
				}
			}
		  } else {
			  $titulo = 'No se ha recibido el identificador de la cancion a reproducir';
		  }

  ?>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <div class="wrapper">
	<h1><marquee id="dplz" scrollamount="10" height="75px" width="800px">Sound Coffee</marquee></h1>
	<h2>By 1º DAM - Florida Universitaria</h2>
	<audio src="" id="hidden-player"></audio>
	<div id="player">
		<img src="" class="coverr" alt="" height="200" width="200" />
		<div class="player-song">
			<div class="title"></div>
			<div class="artist"></div>
			<progress value="0" max="1"></progress>
			<div class="timestamps">
				<div class="time-now">0:00:00</div>
				<div class="time-finish">0:00:00</div>
			</div>
			<div class="actions">
				<div class="play">
					<a class="play-button paused" href="#">
						<div class="left"></div>
						<div class="right"></div>
						<div class="triangle-1"></div>
						<div class="triangle-2"></div>
					</a>
				</div>
				<div>
					<a href="form.php" class="mdl-button mdl-js-button" style="color:black">
					<i class="material-icons">queue</i></a>
				</div>
			</div>
			<br>
			<div class="mdl-cell--12-col">
					<a href="http://music.jhorje18.com/index.php?enlace=<?php echo $enlace ?>&artista=<?php echo $artista ?>&foto=<?php echo $foto ?>&descarga=song" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-cell--6-col" style="background-color:greenyellow" <?php if($enlace) {echo 'disable'} ?>>
					<i class="material-icons">music_note</i> Descargar</a>

					<a href="http://music.jhorje18.com/index.php?enlace=<?php echo $enlace ?>&artista=<?php echo $artista ?>&foto=<?php echo $foto ?>&descarga=app" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-cell--6-col" style="background-color:aqua">
					<i class="material-icons">file_download</i> Aplicación</a>
				</div>
		</div>
	</div>
</div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script>
var num = 0;
var hiddenPlayer = $('#hidden-player');
var player = $('#player');
var title = $('.title');
var artist = $('.artist');
var cover = $('.coverr');

//Logo animacion
var txt = document.getElementById("dplz"); 
txt.stop();

function secondsTimeSpanToHMS(s) {
	var h = Math.floor(s / 3600); //Get whole hours
	s -= h * 3600;
	var m = Math.floor(s / 60); //Get remaining minutes
	s -= m * 60;
	return h + ":" + (m < 10 ? '0' + m : m) + ":" + (s < 10 ? '0' + s : s); //zero padding on minutes and seconds
};

songs = [{
		//Recibe parametros de la cancion a reproducir
		src: "MUSICA/<?php echo $enlace ?>",
		title: "<?php echo $titulo ?>",
		artist: "<?php echo $artista ?>",
		coverart: "<?php echo $foto ?>"
	}
];

var initSongSrc = songs[0].src;
var initSongTitle = songs[0].title;
var initSongArtist = songs[0].artist;
var initSongCover = songs[0].coverart;

hiddenPlayer.attr("src", initSongSrc);
title.html(initSongTitle);
artist.html(initSongArtist);
cover.attr('src', initSongCover);

hiddenPlayer.attr('order', '0');
hiddenPlayer[0].onloadedmetadata = function() {
	var dur = hiddenPlayer[0].duration;
	var songLength = secondsTimeSpanToHMS(dur)
	var songLengthParse = songLength.split(".")[0];
	$('.time-finish').html(songLengthParse);
};

var items = songs.length - 1;

$('.next').on('click', function() {
	var songOrder = hiddenPlayer.attr('order');

	if (items == songOrder) {
		num = 0;
		var songSrc = songs[0].src;
		var songTitle = songs[0].title;
		var songArtist = songs[0].artist;
		var songCover = songs[0].coverart;
		hiddenPlayer.attr('order', '0');
		hiddenPlayer.attr('src', songSrc).trigger('play');
		title.html(songTitle);
		artist.html(songArtist);
		cover.attr('src', songCover);
	} else {
		console.log(songOrder);
		num += 1;
		var songSrc = songs[num].src;
		var songTitle = songs[num].title;
		var songArtist = songs[num].artist;
		var songCover = songs[num].coverart;
		hiddenPlayer.attr('src', songSrc).trigger('play');
		title.html(songTitle);
		artist.html(songArtist);
		cover.attr('src', songCover);
		hiddenPlayer.attr('order', num);
	}
});

$('.prev').on('click', function() {
	var songOrder = hiddenPlayer.attr('order');

	if (songOrder == 0) {
		num = items;
		var songSrc = songs[items].src;
		var songTitle = songs[items].title;
		var songArtist = songs[items].artist;
		hiddenPlayer.attr('order', items);
		hiddenPlayer.attr('src', songSrc).trigger('play');
		title.html(songTitle);
		artist.html(songArtist);
	} else {
		num -= 1;
		var songSrc = songs[num].src;
		var songTitle = songs[num].title;
		var songArtist = songs[num].artist;
		hiddenPlayer.attr('src', songSrc).trigger('play');
		title.html(songTitle);
		artist.html(songArtist);
		hiddenPlayer.attr('order', num);
	}
});

$(".play-button").click(function() {
	$(this).toggleClass("paused");
	if ($(this).hasClass("paused")) {
		hiddenPlayer[0].pause();
		txt.stop();
	} else {
		hiddenPlayer[0].play();
		txt.start();
		txt.setAttribute("behavior", "Alternate");
		txt.setAttribute("bgcolor","#000000");
	}
});

hiddenPlayer.on('timeupdate', function() {
	var songLength = secondsTimeSpanToHMS(this.duration)
	var songLengthParse = songLength.split(".")[0];
	$('.time-finish').html(songLengthParse);

	var songCurrent = secondsTimeSpanToHMS(this.currentTime)
	var songCurrentParse = songCurrent.split(".")[0];
	$('.time-now').html(songCurrentParse);
	$('progress').attr("value", this.currentTime / this.duration);

	if (!hiddenPlayer[0].paused) {
		$(".play-button").removeClass('paused');
		$('progress').css('cursor', 'pointer');
		
		
		$('progress').on('click', function(e) {
			var parentOffset = $(this).parent().offset(); 
			var relX = e.pageX - parentOffset.left;
			var percPos = relX * 100 / 355;
			var second = hiddenPlayer[0].duration * parseInt(percPos) / 100;
			console.log(second);
			hiddenPlayer[0].currentTime = second;
		})
	}
	
	if (this.currentTime == this.duration) {
		$('.next').trigger('click');
	}
});
    </script>

</body>
</html>