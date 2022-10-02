<!DOCTYPE html>
<html lang="es">
  <meta http-equiv="refresh" content="60">
  <head>
    <?php 
      if(!isset($_POST["class"])) $class = "2DAWM";
      else $class = $_POST["class"];

      echo "<title>Horario {$class}</title>";
    ?> 
  </head>
  <body>
    <link rel="stylesheet" href="styles/style.css">
    <?php include 'scripts/functions.php'; ?>
    
    <form action="ongoingSubject.php" method="post" enctype="multipart/form-data">
      <h3>Seleccione el horario que desea ver:</h3>
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
      <br>
      <input type="submit" value="Enviar" name="submit">
    </form>

    <?php  
        echo "<h1>Ahora en la clase de {$class} toca:</h1>";
        findCurrentSubject($class);
    ?>
    
    <h2 style="padding-top: 35px">Consultar Horario Completo</h2>
    <form style="padding-top: 35px" action="schedule.php" id="form" method="POST">
      <input type="hidden" id="class" name="class" value="<?php echo $class?>">
      <input name="submit" id="img" type="image" src="images/schedule_img.png" alt="Consultar Horario completo">
    </form>  
  </body>
</html>