<!DOCTYPE html>
<html lang="es">
  <meta http-equiv="refresh" content="10">
  <head>
    <title>Horario 2ºDAW - Mañana</title>
  </head>
  <body>
    <link rel="stylesheet" href="styles.css">
    <?php include 'data.php'; include 'functions.php'; ?>

    <br/>
    <h1>Ahora en la clase de 2º DAW - Mañana toca:</h1>
    <?php findSubject(null, null, null);?>
    
    <h2 style="padding-top: 35px">Consultar Horario Completo</h2>
    <form style="padding-top: 35px" action="ut1.4-2.php" id="form" method="POST">
      <input name="submit" id="img" type="image" src="schedule.png" alt="Consultar Horario completo">
    </form>  
  </body>
</html>