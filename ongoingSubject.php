<!DOCTYPE html>
<html lang="es">
  <meta http-equiv="refresh" content="60">
  <head>
    <?php include 'scripts/functions.php'; 
      session_start();
      if(!isset($_POST["class"]) && !isset($_SESSION["class"])) $class = "2DAW_M";
      else
        if(isset($_POST["class"])){
          $class = $_POST["class"];
          $_SESSION["class"] = $class;
        }else{
          $class = $_SESSION["class"];
        }

        $name = getName($class);
        echo "<title>Horario de {$name}</title>";
    ?> 
  </head>
  <body>
    <link rel="stylesheet" href="styles/style.css">
    
    <form action="ongoingSubject.php" method="post" enctype="multipart/form-data">
      <h3>Seleccione el horario que desea ver:</h3>
      <select id="class" name="class" required>
        <optgroup label="Grupos">
          <option value="1CIB_M">Ciberseguridad</option>
          <option value="1ASIR_M">1º ASIR - Mañana</option>
          <option value="1DAM_M">1º DAM - Mañana</option>
          <option value="1DAW_M">1º DAW - Mañana</option>
          <option value="1SMR_AM">1ºA SMR - Mañana</option>
          <option value="1SMR_BM">1ºB SMR - Mañana</option>
          <option value="2ASIR_M">2º ASIR - Mañana</option>
          <option value="2DAM_M">2º DAM - Mañana</option>
          <option value="2DAW_M">2º DAW - Mañana</option>
          <option value="2SMR_M">2º SMR - Mañana</option>
        </optgroup>
        <optgroup label="Docentes">
          <option value="D_SRS">Sergio Rámoz Suárez</option>
          <option value="D_JIZ">Jose Ignacio Zaballos</option>
          <option value="D_COA">Carlos Ojeda Alemán</option>
          <option value="D_JJRM">Jose Juan Rodríguez Martín</option>
          <option value="D_JAGA">Juan Alejandro García Arbelo</option>
        </optgroup>  
      </select>  
      <br>
      <input type="submit" value="Buscar" name="submit">
    </form>

    <?php  
      if(substr($class, 0, 1) != "D"){
        echo "<h1>Ahora en la clase de {$name} toca:</h1>";
        findCurrentSubjectGroup($class);
      }else{
        echo "<h1>Ahora a {$name} le toca:</h1>";
        findCurrentSubjectTeacher($class);
      }
    ?>
    
    <h2 style="padding-top: 35px">Consultar Horario Completo</h2>
    <form style="padding-top: 35px" action="schedule.php" id="form" method="POST">
      <input type="hidden" id="class" name="class" value="<?php echo $class?>">
      <input name="submit" id="img" type="image" src="images/schedule_img.png" alt="Consultar Horario completo">
    </form>  
  </body>
</html>