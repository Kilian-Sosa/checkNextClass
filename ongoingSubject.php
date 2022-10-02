<!DOCTYPE html>
<html lang="es">
  <meta http-equiv="refresh" content="60">
  <head>
    <title>Horario 2ºDAW - Mañana</title>
  </head>
  <body>
    <link rel="stylesheet" href="styles/style.css">
    <?php include 'scripts/functions.php'; ?>
    
    <form action="ongoingSubject.php" method="post" enctype="multipart/form-data">
      <h3>Seleccione el horario de:</h3>
      <!--
      <select id="class" name="class" required>
        <optgroup label="Grupos">
          <option value="2DAWM">2º DAW - Mañana</option>
          <option value="2DAMM">2º DAM - Mañana</option>
        </optgroup>
        <optgroup label="Docentes">
          <option value="2DAWM">2º DAW - Mañana</option>
          <option value="2DAMM">2º DAM - Mañana</option>
        </optgroup>  
      </select>  
      -->
      <select id="class" name="class" required>
        <option value="2DAWM">2º DAW - Mañana</option>
        <option value="2DAMM">2º DAM - Mañana</option>
      </select>  
      <input type="submit" value="Enviar" name="submit">
    </form>

    <h1>Ahora en la clase de 2º DAW - Mañana toca:</h1>
    <br/>
    <?php  
        if(count($_POST)) findCurrentSubject($_POST["class"]);
        else findCurrentSubject(null);
    ?>
    
    <h2 style="padding-top: 35px">Consultar Horario Completo</h2>
    <form style="padding-top: 35px" action="schedule.php" id="form" method="POST">
      <input name="submit" id="img" type="image" src="images/schedule_img.png" alt="Consultar Horario completo">
    </form>  
  </body>
</html>