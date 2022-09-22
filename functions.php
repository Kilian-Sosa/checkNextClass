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
        global $schedule;

        if($hourA == 8 && $minutesA < 55) $class = "0";
        elseif($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $class = "1";
        elseif($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $class = "2";
        elseif($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) $class = "7";
        elseif($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $class = "4";
        elseif($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $class = "5";
        else $class = "6";

        if($class == "7"){
            echo "<br/><table><tr><td>¡Toca recreo!</td></tr></table>";
            return;
        }

        for($i = 1; $i < 7; $i++){
            foreach($schedule as $day => $subjects){
                if($day != $dayA) continue;
                if($day == "Mo") $dayS = "Lunes";
                elseif($day == "Tu") $dayS = "Martes";
                elseif($day == "We") $dayS = "Miércoles";
                elseif($day == "Th") $dayS = "Jueves";
                elseif($day == "Fr") $dayS = "Viernes";
                if($minutesA < 10) {
                    $minutes = "0{$minutesA}";
                    echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>El {$dayS} a las {$hourA}:{$minutes} Toca {$subjects[$class]}</h3>";
                }else echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>El {$dayS} a las {$hourA}:{$minutesA} Toca {$subjects[$class]}</h3>";
                return;
            }
        }
    }

    function findCurrentSubject(){
        global $schedule, $legend;
        date_default_timezone_set("Europe/London");
        $dayA = substr(date(DATE_RFC850), 0, 2);
        $hourA = date("H");
        $minutesA = date("i");
        $class = null;
        
        if($hourA == 8 && $minutesA < 55) $class = "0";
        elseif($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $class = "1";
        elseif($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $class = "2";
        elseif($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) $class = "7";
        elseif($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $class = "4";
        elseif($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $class = "5";
        elseif($hourA == 13 && $minutesA >= 05) $class = "6";

        if($class == "7"){
            echo "<br/><table><tr><td>¡Ahora toca recreo!</td></tr></table>";
            checkNextClass($dayA, $hourA, $minutesA);
            return;
        }elseif(is_null($class) || $dayA == "Sa" || $dayA == "Su"){
            checkNextClass($dayA, $hourA, $minutesA);
            return;
        }

        for($i = 1; $i < 7; $i++){
            foreach($schedule as $day => $subjects){
                if($day != $dayA) continue;
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
                return;
            }
        }
    }

    function checkNextClass($dayA, $hourA, $minutesA){
        global $schedule, $legend;
    
        if($hourA == 10 && $minutesA >= 45  || $hourA == 11 && $minutesA < 15) $class = "7";
        elseif($hourA < 8) $class = "8";
        else{
            $class = "9";
            if($dayA == "Mo") $dayS = "Tu";
            elseif($dayA == "Tu") $dayS = "We";
            elseif($dayA == "We") $dayS = "Th";
            elseif($dayA == "Th") $dayS = "Fr";
            elseif($dayA == "Fr") $dayS = "Mo";
        }

        foreach($schedule as $day => $subjects){
            if($class == "7" && $day == $dayA){
                    $time = (new DateTime('now')) -> diff((new DateTime('now')) -> setTime(11, 45, 0, 0));
                    echo "<h2>La siguiente clase es dentro de {$time->format('%h horas, %i minutos y %s segundos')}:</h2>";
                    foreach($legend as $subject => $info){
                        if($subject != $subjects[4]) continue;?>
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
                    <?php return;}
            }elseif($class == "8" && $day == $dayA){
                    $time = (new DateTime('now')) -> diff((new DateTime('now')) -> setTime(8, 0, 0, 0));
                    echo "<h2>La siguiente clase es dentro de {$time->format('%h horas, %i minutos y %s segundos')}:</h2>";
                    foreach($legend as $subject => $info){
                        if($subject != $subjects[0]) continue;?>
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
                    <?php return;}
            }elseif($day == $dayS || $dayS == "Mo"){
                $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+1 day')) -> setTime(8, 0, 0, 0));
                echo "<h2>La siguiente clase es dentro de {$time->format('%h horas, %i minutos y %s segundos')}:</h2>";
                foreach($legend as $subject => $info){
                    if($subject != $subjects[0]) continue;?>
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
                <?php return;}
            }elseif($dayA == "Sa" || $dayA == "Su"){
                foreach($legend as $subject => $info){
                    if($subject != $subjects[0]) continue;
                    
                    if($dayA == "Sa") $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+2 day') -> setTime(8, 0, 0, 0)));
                    else $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+1 day') -> setTime(8, 0, 0, 0)));
                    echo "<h2>La siguiente clase es dentro de {$time -> format('%d días, %h horas, %i minutos y %s segundos')}:</h2>";?>
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
                <?php return;}
            }
        }
    }
?>