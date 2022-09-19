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
      h1 {
        text-align: center;
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
  </body>
</html>