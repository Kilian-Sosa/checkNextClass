<?php  
    function printSchedule($class){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$class}']");
        
        foreach($schedules as $schedule){ 
            for($i = 0; $i < sizeof($schedule -> day[0]); $i++){ ?>
                <tr>
                    <td><?php echo $schedule -> ti -> class[$i];?></td>
                    <td><?php echo $schedule -> day[0] -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule -> day[1] -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule -> day[2] -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule -> day[3] -> class[$i] -> initials;?></td>
                    <td><?php echo $schedule -> day[4] -> class[$i] -> initials;?></td>
                </tr>
            <?php }
        }    
    };

    function printLegendGroup($class){
        $root = simplexml_load_file("./data/database.xml");
        $legends = $root -> xpath("//legend[@id = '{$class}']");

        foreach($legends as $legend){ 
            for($i = 0; $i < sizeof($legend); $i++){ ?>
                <tr>
                    <td><?php echo $legend -> class[$i] -> initials;?></td>
                    <td><?php echo $legend -> class[$i] -> subject;?></td>
                    <td><?php echo $legend -> class[$i] -> teacher;?></td>
                    <td><?php echo $legend -> class[$i] -> classroom;?></td>
                </tr>
            <?php }
        }    
    }

    function printLegendTeacher($class){
        $root = simplexml_load_file("./data/database.xml");
        $legends = $root -> xpath("//legend[@id = '{$class}']");

        foreach($legends as $legend){ 
            for($i = 0; $i < sizeof($legend); $i++){ ?>
                <tr>
                    <td><?php echo $legend -> class[$i] -> group;?></td>
                    <td><?php echo $legend -> class[$i] -> initials;?></td>
                    <td><?php echo $legend -> class[$i] -> subject;?></td>
                    <td><?php echo $legend -> class[$i] -> classroom;?></td>
                </tr>
            <?php }
        }    
    }

    function getName($class){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$class}']");

        foreach($schedules as $schedule){
            return $schedule -> name;
        }
    }

    function findSubject($dayA, $hourA, $minutesA, $class){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$class}']");
        $legends = $root -> xpath("//legend[@id = '{$class}']");

        if($hourA == 8 && $minutesA < 55) $hour = "08:00-08:55";
        elseif($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $hour = "08:55-09:50";
        elseif($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $hour = "09:50-10:45";
        elseif($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) {
            echo "<br/><table><tr><td>¡Toca recreo!</td></tr></table>";
            return;
        }elseif($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $hour = "11:15-12:10";
        elseif($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $hour = "12:10-13:05";
        elseif($hourA == 13 && $minutesA >= 05 || $hourA == 14 && $minutesA == 0) $hour = "13:05-14:00";

        for($i = 1; $i < 7; $i++){
            foreach($schedules as $schedule){ 
                $subjects = $schedule -> xpath("./day[@id = '{$dayA}']/class[@id = '{$hour}']");
                foreach($subjects as $subject) 
                    $initialsS = $subject -> initials;

                if($dayA == "mo") $dayS = "Lunes";
                elseif($dayA == "tu") $dayS = "Martes";
                elseif($dayA == "we") $dayS = "Miércoles";
                elseif($dayA == "th") $dayS = "Jueves";
                elseif($dayA == "fr") $dayS = "Viernes";
                if($minutesA < 10) {
                    $minutes = "0{$minutesA}";
                    echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>El {$dayS} a las {$hourA}:{$minutes} Toca:</h3>";
                }else echo "<h3 style='margin-left:auto; margin-right:auto; width:30%; background-color: lightblue;'>El {$dayS} a las {$hourA}:{$minutesA} Toca:</h3>";
                

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

    function findCurrentSubjectGroup($class){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$class}']");
        $legends = $root -> xpath("//legend[@id = '{$class}']");

        date_default_timezone_set("Europe/London");
        $dayA = strtolower(substr(date(DATE_RFC850), 0, 2));
        
        $hourA = date("H");
        $minutesA = date("i");
        $hour = "7";
        if($hourA == 8 && $minutesA < 55) $hour = "08:00-08:55";
        elseif($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $hour = "08:55-09:50";
        elseif($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $hour = "09:50-10:45";
        elseif($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) $hour = "10:45-11:15";
        elseif($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $hour = "11:15-12:10";
        elseif($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $hour = "12:10-13:05";
        elseif($hourA == 13 && $minutesA >= 05 || $hourA == 14 && $minutesA == 0) $hour = "13:05-14:00";
        elseif($hourA >= 14) $hour = "15";

        if($hour == "10:45-11:15" || $hour == "7" || $hour == "15" || $dayA == "fr" && $hour == "15" || $dayA == "sa" || $dayA == "su"){
            if($hour == "7"){
                $time = (new DateTime('now')) -> diff((new DateTime('now')) -> setTime(8, 0, 0, 0));
            }elseif($hour == "10:45-11:15") {
                echo "<br/><table><tr><td>¡Ahora toca recreo!</td></tr></table>";
                $time = (new DateTime('now')) -> diff((new DateTime('now')) -> setTime(11, 15, 0, 0));
            }elseif($dayA == "fr" || $dayA == "sa" || $dayA == "su")
                if($dayA == "fr") $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+3 day') -> setTime(8, 0, 0, 0)));
                elseif($dayA == "sa") $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+2 day') -> setTime(8, 0, 0, 0)));
                else $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+1 day') -> setTime(8, 0, 0, 0)));
            else $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+1 day')) -> setTime(8, 0, 0, 0));

            echo "<h2>La siguiente clase es dentro de {$time -> format('%h horas y %i minutos')}:</h2>";
            checkNextClass($dayA, $hourA, $minutesA, $class);
            return;
        }

        for($i = 1; $i < 7; $i++){
            foreach($schedules as $schedule){ 
                $subjects = $schedule -> xpath("./day[@id = '{$dayA}']/class[@id = '{$hour}']");
                foreach($subjects as $subject)
                    $initialsS = $subject -> initials;

                foreach($legends as $legend){  
                    foreach($legends as $legend){ 
                        for($i = 0; $i < sizeof($legend); $i++){ 
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
                                    <td><?php echo $legend -> class[$i] -> group;?></td>
                                    <td><?php echo $legend -> class[$i] -> initials;?></td>
                                    <td><?php echo $legend -> class[$i] -> subject;?></td>
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

    function findCurrentSubjectTeacher($teacher){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$teacher}']");
        $legends = $root -> xpath("//legend[@id = '{$teacher}']");

        date_default_timezone_set("Europe/London");
        $dayA = strtolower(substr(date(DATE_RFC850), 0, 2));
        
        $hourA = date("H");
        $minutesA = date("i");
        $hour = "7";
        if($hourA == 8 && $minutesA < 55) $hour = "08:00-08:55";
        elseif($hourA == 8 && $minutesA >= 55 || $hourA == 9 && $minutesA < 50) $hour = "08:55-09:50";
        elseif($hourA == 9 && $minutesA >= 50 || $hourA == 10 && $minutesA < 45) $hour = "09:50-10:45";
        elseif($hourA == 10 && $minutesA >= 45 || $hourA == 11 && $minutesA < 15) $hour = "10:45-11:15";
        elseif($hourA == 11 && $minutesA >= 15 || $hourA == 12 && $minutesA < 10) $hour = "11:15-12:10";
        elseif($hourA == 12 && $minutesA >= 10 || $hourA == 13 && $minutesA < 05) $hour = "12:10-13:05";
        elseif($hourA == 13 && $minutesA >= 05 || $hourA == 14 && $minutesA == 0) $hour = "13:05-14:00";
        elseif($hourA >= 14) $hour = "15";

        if($hour == "10:45-11:15" || $hour == "7" || $hour == "15" || $dayA == "fr" && $hour == "15" || $dayA == "sa" || $dayA == "su"){
            if(is_null($hour)){
                $time = (new DateTime('now')) -> diff((new DateTime('now')) -> setTime(8, 0, 0, 0));
            }elseif($hour == "10:45-11:15") {
                echo "<br/><table><tr><td>¡Ahora toca recreo!</td></tr></table>";
                $time = (new DateTime('now')) -> diff((new DateTime('now')) -> setTime(11, 15, 0, 0));
            }elseif($dayA == "fr" || $dayA == "sa" || $dayA == "su")
                if($dayA == "fr") $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+3 day') -> setTime(8, 0, 0, 0)));
                elseif($dayA == "sa") $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+2 day') -> setTime(8, 0, 0, 0)));
                else $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+1 day') -> setTime(8, 0, 0, 0)));
            else $time = (new DateTime('now')) -> diff(((new DateTime('now')) -> modify('+1 day')) -> setTime(8, 0, 0, 0));

            echo "<h2>La siguiente clase es dentro de {$time -> format('%h horas y %i minutos')}:</h2>";
            checkNextClass($dayA, $hourA, $minutesA, $teacher);
            return;
        }

        for($i = 1; $i < 7; $i++){
            foreach($schedules as $schedule){ 
                $subjects = $schedule -> xpath("./day[@id = '{$dayA}']/class[@id = '{$hour}']");
                foreach($subjects as $subject)
                    $initialsS = $subject -> initials;

                foreach($legends as $legend){  
                    foreach($legends as $legend){ 
                        for($i = 0; $i < sizeof($legend); $i++){ 
                            $initialsL = $legend -> class[$i] -> initials;
                            if(print_r($initialsL, true) != print_r($initialsS, true)) continue;?>
                            <table>
                                <tr>
                                    <th>Grupo</th>
                                    <th>Código</th>
                                    <th>Materia</th>
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


    function checkNextClass($dayA, $hourA, $minutesA, $class){
        $root = simplexml_load_file("./data/database.xml");
        $schedules = $root -> xpath("//schedule[@id = '{$class}']");
        $legends = $root -> xpath("//legend[@id = '{$class}']");
        $dayS = $dayA;
    
        $hour = "08:00-08:55";
        if($hourA == 10 && $minutesA >= 45  || $hourA == 11 && $minutesA < 15) $hour = "11:15-12:10";
        elseif($hourA < 8 && ($dayA != "sa" && $dayA != "su")) $hour = "08:00-08:55";
        else{
            if($dayA == "mo") $dayS = "tu";
            elseif($dayA == "tu") $dayS = "we";
            elseif($dayA == "we") $dayS = "th";
            elseif($dayA == "th") $dayS = "fr";
            elseif($dayA == "fr" || $dayA == "sa" || $dayA == "su") $dayS = "mo";
        }
        
        foreach($schedules as $schedule){
            $subjects = $schedule -> xpath("./day[@id = '{$dayS}']/class[@id = '{$hour}']");
            foreach($subjects as $subject){
                $initialsS = $subject -> initials;
            }

            foreach($legends as $legend){  
                foreach($legends as $legend){ 
                    for($i = 0; $i < sizeof($legend); $i++){ 
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
            }
        }
    }
?>