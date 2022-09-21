
    <?php 

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