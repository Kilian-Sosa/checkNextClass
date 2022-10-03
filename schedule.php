<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include 'scripts/functions.php';
      if(!isset($_POST["class"])) $class = "2DAWM";
      else $class = $_POST["class"];
      $name = getName($class);
      echo "<title>Horario de {$name}</title>";?> 
  </head>
  <body>
    <link rel="stylesheet" href="styles/style.css">
    <form style="text-align: left" action="ongoingSubject.php" id="form" method="POST">
      <input name="submit" id="img" type="image" src="images/back_arrow.png" alt="Volver Atrás" width="45px" style="padding-left: 10px; padding-top: 10px">
    </form>  
    <?php 
      echo "<h1>Horario de {$name}</h1>";?>
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
      <?php if(substr($class, 0, 1) != "D"){?>
        <tr>
          <th>Código</th>
          <th>Materia</th>
          <th>Docente</th>
          <th>Aula</th>
        </tr>  
        <?php printLegendGroup($class);
      }else{?>
        <tr>
          <th>Grupo</th>
          <th>Código</th>
          <th>Materia</th>
          <th>Aula</th>
        </tr>  
        <?php printLegendTeacher($class);
      }?>
    </table>
    <br/>
    <h3>Buscar qué toca eligiendo día y hora:</h3>
    <select id="day" name="day" form="formA">
      <option value="mo">Lunes</option>
      <option value="tu">Martes</option>
      <option value="we">Miércoles</option>
      <option value="th">Jueves</option>
      <option value="fr">Viernes</option>
    </select>
    <br/>
    <form class="form" action="schedule.php" id="formA" method="POST">
      <input type="number" maxlength="2" required="true" onKeyDown="return false" id="hour" name="hour" placeholder="Hora" min="8" max="13">
      <input type="number" maxlength="2" default="0" onKeyDown="return false" id="minutes" name="minutes" placeholder="Minutos" min="0" max="59">
      <input type="hidden" id="class" name="class" value="<?php echo $class?>">
      <input type="submit">
    </form>  
    <?php if(isset($_POST["day"])) findSubject($_POST['day'], $_POST['hour'], $_POST['minutes'], $class);?>
  </body>
</html>