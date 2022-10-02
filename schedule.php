<!DOCTYPE html>
<html lang="es">
  <head>
    <?php 
      if(!isset($_POST["class"])) $class = "2DAWM";
      else $class = $_POST["class"];
      echo "<title>Horario {$class}</title>";?> 
  </head>
  <body>
    <link rel="stylesheet" href="styles/style.css">
    <?php include 'scripts/functions.php'; ?>
    <form style="text-align: left" action="ongoingSubject.php" id="form" method="POST">
      <input name="submit" id="img" type="image" src="images/back_arrow.png" alt="Volver Atrás" width="45px" style="padding-left: 10px; padding-top: 10px">
    </form>  
    <?php echo "<h1>Horario de {$class}</h1>";?>
    <br/>
    <table>
      <tr>
        <th></th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
      </tr>
      <?php printSchedule($class);?>
    </table>
    <br/>
    <table>
      <tr>
        <th>Código</th>
        <th>Materia</th>
        <th>Docente</th>
        <th>Aula</th>
      </tr>  
      <?php printLegend($class);?>
    </table>
    <br/>
    <h3>Buscar qué toca eligiendo día y hora:</h3>
    <select id="day" name="day" form="formA">
      <option value="Mo">Lunes</option>
      <option value="Tu">Martes</option>
      <option value="We">Miércoles</option>
      <option value="Th">Jueves</option>
      <option value="Fr">Viernes</option>
    </select>
    <br/>
    <form class="form" action="schedule.php" id="formA" method="POST">
      <input type="number" maxlength="2" required="true" onKeyDown="return false" id="hour" name="hour" placeholder="Hora" min="8" max="13">
      <input type="number" maxlength="2" default="0" onKeyDown="return false" id="minutes" name="minutes" placeholder="Minutos" min="0" max="59">
      <input type="submit">
    </form>  
    <?php #if(count($_POST) > 2) findSubject($_POST['day'], $_POST['hour'], $_POST['minutes']);?>
  </body>
</html>