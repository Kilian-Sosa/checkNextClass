<?php  
    function printSchedule(){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '2DAWM']");
        
        foreach($schedules as $schedule){ 
            for($i = 0; $i < 7; $i++){ ?>
                <tr>
                    <td><?php echo $schedule -> ti -> class[$i];?></td>
                    <td><?php echo $schedule  -> mo -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule  -> tu -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule  -> we -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule  -> th -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule  -> fr -> class[$i] -> initials;?></td>
                </tr>
            <?php }
        }    
    };

    function printLegend(){
        $root = simplexml_load_file("./data/database.xml");
        $legends = $root -> xpath("//legend[@id = '2DAWM']");

        foreach($legends as $legend){ 
            for($i = 0; $i < 5; $i++){ ?>
                <tr>
                    <td><?php echo $legend -> class[$i] -> initials;?></td>
                    <td><?php echo $legend -> class[$i] -> subject;?></td>
                    <td><?php echo $legend -> class[$i] -> teacher;?></td>
                    <td><?php echo $legend -> class[$i] -> classroom;?></td>
                </tr>
            <?php }
        }    
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

    function findCurrentSubject($class){
        if($class == null) $class = "2DAWM";
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$class}']");
        $legends = $root -> xpath("//legend[@id = '{$class}']");

        date_default_timezone_set("Europe/London");
        $dayA = strtolower(substr(date(DATE_RFC850), 0, 2));
        $hourA = date("H");
        $minutesA = date("i");
        $hour = null;

        if($hourA == 8 && $minutesA < 55) $hour = "0";
        elseif($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $hour = "1";
        elseif($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $hour = "2";
        elseif($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) $hour = "7";
        elseif($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $hour = "4";
        elseif($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $hour = "5";
        elseif($hourA == 13 && $minutesA >= 05) $hour = "6";

        if($hour == "7" || is_null($hour) || $dayA == "Sa" || $dayA == "Su"){
            if($hour == "7") echo "<br/><table><tr><td>¡Ahora toca recreo!</td></tr></table>";
            checkNextClass($dayA, $hourA, $minutesA);
            return;
        }

        for($i = 1; $i < 7; $i++){
            foreach($schedules as $schedule){ 
                $day = $schedule -> fr;
                $subjects = $day -> xpath("//class[@id = '{$hour}']");
                foreach($subjects as $subject){
                    $initialsS = $subject -> initials;
                }

                foreach($legends as $legend){  
                    foreach($legends as $legend){ 
                        for($i = 0; $i < 5; $i++){ 
                            $initialsL = $legend -> class[$i] -> initials;
                            if(print_r($initialsL, true) != print_r($initialsS, true)) continue;?>
                            <table>
                                <tr>
                                    <th>Código</th>
                                    <th>Materia</th>
                                    <th>Docente</th>
                                    <th>Aula</th>
                                </tr>
                                <tr>
                                    <td><?php echo $initialsL;?></td>
                                    <td><?php echo $legend -> class[$i] -> subject;?></td>
                                    <td><?php echo $legend -> class[$i] -> teacher;?></td>
                                    <td><?php echo $legend -> class[$i] -> classroom;?></td>
                                </tr>
                            </table>
                        <?php }
                    }       
                    return;
                }
            }    
        }
    }

    function checkNextClass($dayA, $hourA, $minutesA){
        global $schedule, $legend;
    
        if($hourA == 10 && $minutesA >= 45  || $hourA == 11 && $minutesA < 15) $hour = "7";
        elseif($hourA < 8) $hour = "8";
        else{
            $hour = "9";
            if($dayA == "Mo") $dayS = "Tu";
            elseif($dayA == "Tu") $dayS = "We";
            elseif($dayA == "We") $dayS = "Th";
            elseif($dayA == "Th") $dayS = "Fr";
            elseif($dayA == "Fr") $dayS = "Mo";
        }

        foreach($schedule as $day => $subjects){
            if($hour == "7" && $day == $dayA){
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
            }elseif($hour == "8" && $day == $dayA){
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