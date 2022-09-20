<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Horario 2ºDAW - Mañana</title>
  </head>
  <body>
    <style>
      table, th, td {
        border: 1px solid black;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
      }
      th {
        background-color: lightblue;
      }
      h1, h3, select, form {
        text-align: center;
      }
      select {
        display: block;
        margin: 0 auto;
      }
    </style>
    <?php 
        $schedule = array(
            "Time" => array("08:00-08:55", "08:55-09:50", "09:50-10:45", "10:45-11:15", "11:15-12:10", "12:10-13:05", "13:05-14:00"),
            "L" => array("EMR", "DSW", "DSW", "R", "DEW", "DEW", "DEW"),
            "M" => array("DPL", "DPL", "DSW", "E", "DSW", "DOR", "DOR"),
            "X" => array("DEW", "DEW", "DSW", "CR", "DSW", "DOR", "DOR"),
            "J" => array("DPL", "DPL", "DPL", "E", "DEW", "DEW", "EMR"),
            "V" => array("DOR", "DOR", "DPL", "O", "EMR", "DSW", "DSW")
        );
        
        $legend = array(
            "DSW" => array("Desarrollo Web en Entorno Servidor", "Sergio Ramos Suárez", "201"),
            "DEW" => array("Desarrollo Web en Entorno Cliente", "María del Carmen Rodríguez Suárez", "201"),
            "DPL" => array("Despliegue de Aplicaciones Web", "Maria Antonia Montesdeoca Viera", "201"),
            "DOR" => array("Diseño de Interfaces Web", "Ermis Papakonstantinou Báez", "201"),
            "EMR" => array("Empresa e Iniciativa Emprendedora", "Maria del Sol García Trajano", "201")
        );

        function printSchedule(){
          global $schedule;
            for($i = 0; $i < 7; $i++){ ?>
                <tr>
                    <?php 
                        foreach($schedule as $day => $subjects){?>
                           <td><?php echo $subjects[$i];?></td>
                        <?php }
                      ?>
                </tr>
            <?php }
        };

        function printLegend(){
          global $legend;
            foreach($legend as $subject => $info){?>
                <tr>
                  <td><?php echo $subject;?></td>
                  <?php for($i = 0; $i < 3; $i++){?>
                      <td><?php echo $info[$i];?></td>
                  <?php }?>
                </tr>
            <?php }
        }

        function findSubject(){
          global $schedule;
          $dayA = $_POST['day'];
          $hourA = $_POST['hour'];
          $minutesA = $_POST['minutes'];
          $class;

          if($hourA == 8 && $minutesA < 55) $class = "0";
          if($hourA == 8 && $minutesA > 55 || $hourA == 9 && $minutesA < 50) $class = "1";
          if($hourA == 9 && $minutesA > 50 || $hourA == 10 && $minutesA < 45) $class = "2";
          if($hourA == 10 && $minutesA > 45 || $hourA == 11 && $minutesA < 15) $class = "6";
          if($hourA == 11 && $minutesA > 15 || $hourA == 12 && $minutesA < 10) $class = "3";
          if($hourA == 12 && $minutesA > 10 || $hourA == 13 && $minutesA < 05) $class = "4";
          if($hourA == 13 && $minutesA > 05) $class = "5";

          if($class == "6"){
            echo "<br/><table><tr><td>¡Toca recreo!</td></tr></table>";
            return;
          }

          for($i = 1; $i < 7; $i++){
            foreach($schedule as $day => $subjects){
              if($day != $dayA) continue;
              echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>Toca: {$subjects[$class]}</h3>";
              return;
            }
          }
        }
    ?>
    <h1>Horario 2ºDAW - Mañana</h1>
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
      <?php printSchedule()?>
    </table>
    <br/>
    <table>
      <tr>
        <th>Código</th>
        <th>Materia</th>
        <th>Docente</th>
        <th>Aula</th>
      </tr>  
      <?php printLegend()?>
    </table>
    <h3>Buscar qué toca:</h3>
    <select id="day" name="day" form="form">
      <option value="L">Lunes</option>
      <option value="M">Martes</option>
      <option value="X">Miércoles</option>
      <option value="J">Jueves</option>
      <option value="V">Viernes</option>
    </select>
    <br/>
    <form action="ut1.3.php" id="form" method="POST">
      <input type="number" maxlength="2" required="true" onKeyDown="return false" id="hour" name="hour" placeholder="Hora" min="8" max="13">
      <input type="number" maxlength="2" default="0" onKeyDown="return false" id="minutes" name="minutes" placeholder="Minutos" min="0" max="59">
      <input type="submit">
    </form>  
    <?php
      if(count($_POST)) findSubject();
    ?>
  </body>
</html>