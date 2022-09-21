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
      h1, h2, h3, select, form {
        text-align: center;
      }
      select, button {
        display: block;
        margin: 0 auto;
      }
    </style>
    <?php 
        $schedule = array(
            "Time" => array("08:00-08:55", "08:55-09:50", "09:50-10:45", "10:45-11:15", "11:15-12:10", "12:10-13:05", "13:05-14:00"),
            "Mo" => array("EMR", "DSW", "DSW", "R", "DEW", "DEW", "DEW"),
            "Tu" => array("DPL", "DPL", "DSW", "E", "DSW", "DOR", "DOR"),
            "We" => array("DEW", "DEW", "DSW", "CR", "DSW", "DOR", "DOR"),
            "Th" => array("DPL", "DPL", "DPL", "E", "DEW", "DEW", "EMR"),
            "Fr" => array("DOR", "DOR", "DPL", "O", "EMR", "DSW", "DSW")
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

        function findSubject($dayA, $hourA, $minutesA){
          global $schedule, $legend;
          $flag = false;
          if(is_null($dayA)){
            date_default_timezone_set("Europe/London");
            $dayA = substr(date(DATE_RFC850), 0, 2);
            $hourA = date("h");
            $minutesA = date("i");
            $flag = true;
          }
          //$class;

          if($hourA == 8 && $minutesA < 55) $class = "0";
          if($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $class = "1";
          if($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $class = "2";
          if($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) $class = "7";
          if($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $class = "4";
          if($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $class = "5";
          if($hourA == 13 && $minutesA >= 05) $class = "6";

          if($class == "7"){
            if($flag) echo "<br/><table><tr><td>¡Ahora toca recreo!</td></tr></table>";
            else echo "<br/><table><tr><td>¡Toca recreo!</td></tr></table>";
            return;
          }elseif(is_null($class)){
            echo "<h2>Ahora mismo no toca nada. El horario es de Lunes a Viernes de 8:00 a 14:00</h2>";
          }

          for($i = 1; $i < 7; $i++){
            foreach($schedule as $day => $subjects){
              if($day != $dayA) continue;
              if($flag){
                echo "<h2>Ahora Toca:</h2>";
                foreach($legend as $subject => $info){
                  if($subject != $subjects[$class]) continue;?>
                  <table>
                    <tr>
                      <th>Código</th>
                      <th>Materia</th>
                      <th>Docente</th>
                      <th>Aula</th>
                    </tr>
                    <tr>
                      <td><?php echo $subject;?></td>
                      <?php for($i = 0; $i < 3; $i++){?>
                          <td><?php echo $info[$i];?></td>
                      <?php }?>
                    </tr>
                  </table>
                <?php }
              }else {
                if($day == "Mo") $dayS = "Lunes";
                if($day == "Tu") $dayS = "Martes";
                if($day == "We") $dayS = "Miércoles";
                if($day == "Th") $dayS = "Jueves";
                if($day == "Fr") $dayS = "Viernes";
                if($minutesA < 10) {
                  $minutes = "0{$minutesA}";
                  echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>El {$dayS} a las {$hourA}:{$minutes} Toca {$subjects[$class]}</h3>";
                }else echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>El {$dayS} a las {$hourA}:{$minutesA} Toca {$subjects[$class]}</h3>";
              }
              return;
            }
          }
        }
    ?>
    <h1>Horario 2ºDAW - Mañana</h1>
    <?php findSubject(null, null, null);?>
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
    <form action="ut1.3.php" id="formA" method="POST">
      <input type="number" maxlength="2" required="true" onKeyDown="return false" id="hour" name="hour" placeholder="Hora" min="8" max="13">
      <input type="number" maxlength="2" default="0" onKeyDown="return false" id="minutes" name="minutes" placeholder="Minutos" min="0" max="59">
      <input type="submit">
    </form>  
    <?php if(count($_POST)) findSubject($_POST['day'], $_POST['hour'], $_POST['minutes']);?>
  </body>
</html>