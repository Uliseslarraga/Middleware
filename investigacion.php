<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Middleware</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/colors.css">
</head>
<body class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-center">Middleware</h1>
		</div>
		<div class="row">
			<div class="col-md-9 col-md-offset-2">
				<ul class="nav nav-tabs" role="tablist" id="myTab">
  					<li class="active"><a href="#definicion" role="tab" data-toggle="tab">Definicion</a></li>
  					<li><a href="#genealogia" role="tab" data-toggle="tab">Genealogía</a></li>
  					<li><a href="#servicios" role="tab" data-toggle="tab">Servicios Web</a></li>
  					<li><a href="#computacion" role="tab" data-toggle="tab">Computacion Ubicua</a></li>
  					<li><a href="#grid" role="tab" data-toggle="tab">Grid Computing</a></li>
  					<li><a href="#integracion" role="tab" data-toggle="tab">Integracion de Aplicaciones</a></li>
				</ul>
			</div>
		</div>
		<div class="tab-content">
  			<div class="tab-pane fade in active" id="definicion">
  				<div class="row">
  					<div class="col-md-5 col-md-offset-1">
  						<h1>¿Que es un Middleware?</h1>
  					</div>
  				</div>
  				<div class="row img-thumbnail">
  					<div class="col-md-4 col-md-offset-1"><br>
  						<ul>
  							<li><p class="text-justify">Software de conectividad que consiste en un conjunto de servicios que
								permiten interactuar a múltiples procesos que se ejecutan en distintas
								máquinas a través de una red. Ocultan la heterogeneidad y proveen de un
								modelo de programación conveniente para los desarrolladores de
								aplicaciones</p>
							</li>
							<li><p class="text-justify">La organización IETF (Internet Engineering Task Force) en mayo de 1997 lo
								definió como sigue:<br>
								– “Un Middleware puede ser visto como un conjunto de servicios y
								funciones reutilizables, expandibles, que son comúnmente utilizadas por
								muchas aplicaciones para funcionar bien dentro de un ambiente
								interconectado”.</p>
							</li>
  						</ul><br>
  					</div>
  					<div class="col-md-4 col-md-offset-1"><br>
  						<img class="img-thumbnail" src="public/img/middleware.jpg"><br>
  					</div>
  				</div>
  			</div>
  			<div class="tab-pane fade" id="genealogia">genealogia</div>
  			<div class="tab-pane fade" id="servicios">servicios</div>
 		 	<div class="tab-pane fade" id="computacion">computacion</div>
     	    <div class="tab-pane fade" id="grid">grid</div>
     	    <div class="tab-pane fade" id="integracion">integracion</div>
		</div>
			
	</div>
	<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
  		$(document).ready(function(){ 
    		$("#myTab a").click(function(e){
    		e.preventDefault();
    			$(this).tab('show');
    		});
		});
	</script>
</body>
</html>