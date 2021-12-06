<?php
include_once("header.php")
?>

<?php
$enlace = mysqli_connect("localhost", "root", "", "db_arduino");

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$data_points = array();
$result = mysqli_query($enlace, "SELECT * FROM datos"); 
while ($row = mysqli_fetch_array($result)) {
    $point = array((int)$row[0],(int)$row[1], (int)$row[2], (int)$row[3]);
    array_push($data_points, $point);
}
$data_json=  json_encode($data_points);
mysqli_close($enlace);
?>
<html>
<head><center>
    <h4>Grafico de datos en vivo</h4>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https;//www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Minutos');
        data.addColumn('number', 'Temperatura');
        data.addColumn('number', 'Humedad');
        data.addColumn('number', 'Luz');
        data.addRows(<?php echo $data_json ?>);
        var options = {
            chart: {
            },
            width: 1420,
            height: 500,
            axes: {
            x: {
                0: {side: 'top'}
            }
            }
        };

        var chart = new google.charts.Line(document.getElementById('line_top_x'));

        chart.draw(data, google.charts.Line.convertOptions(options));
        }
    </script>


    
        <script type="text/javascript">
            window.onload = function () {
                var dataLength = 0;
                var data = [];
                var updateInterval = 1000;
                updateChart();
                function updateChart() {
                    $.getJSON("data.php", function (result) {
                        if (dataLength !== result.length) {
                            for (var i = dataLength; i < result.length; i++) {
                                data.push({
                                    x: parseInt(result[i].valorx),
                                    y: parseInt(result[i].valory)
                                });
                            }
                            dataLength = result.length;
                            chart1.render();
                        }
                    });
                }
                var chart1 = new CanvasJS.Chart("Temperatura", {
                    title: {
                        text: "Tiempo vs. Temperatura"
                    },
                    axisX: {
                        title: "Tiempo",
                    },
                    axisY: {
                        title: "Temperatura",
                    },
                    data: [{type: "line", dataPoints: data}],
                });
                setInterval(function () {
                    updateChart()
                }, updateInterval);

                var dataLength1 = 0;
                var data1 = [];
                updateChart1();
                function updateChart1() {
                    $.getJSON("data.php", function (result) {
                        if (dataLength1 !== result.length) {
                            for (var i = dataLength1; i < result.length; i++) {
                                data1.push({
                                    x: parseInt(result[i].valorx),
                                    y: parseInt(result[i].valorz)
                                });
                            }
                            dataLength1 = result.length;
                            chart2.render();
                        }
                    });
                }
                var chart2 = new CanvasJS.Chart("Humedad", {
                    title: {
                        text: "Tiempo vs. Humedad"
                    },
                    axisX: {
                        title: "Tiempo",
                    },
                    axisY: {
                        title: "Humedad",
                    },
                    data: [{type: "line", dataPoints: data1}],
                });

                var dataLength2 = 0;
                var data2 = [];
                updateChart2();
                function updateChart2() {
                    $.getJSON("data.php", function (result) {
                        if (dataLength2 !== result.length) {
                            for (var i = dataLength2; i < result.length; i++) {
                                data2.push({
                                    x: parseInt(result[i].valorx),
                                    y: parseInt(result[i].valork)
                                });
                            }
                            dataLength2 = result.length;
                            chart3.render();
                        }
                    });
                }
                var chart3 = new CanvasJS.Chart("Luz", {
                    title: {
                        text: "Tiempo vs. Humedad"
                    },
                    axisX: {
                        title: "Tiempo",
                    },
                    axisY: {
                        title: "Humedad",
                    },
                    data: [{type: "line", dataPoints: data2}],
                });

                setInterval(function () {
                    updateChart()
                }, updateInterval);
                setInterval(function () {
                    updateChart1()
                }, updateInterval);
                setInterval(function () {
                    updateChart2()
                }, updateInterval);
            }
        </script>

        <script type="text/javascript" src="assets/script/canvasjs.min.js"></script>
        <script type="text/javascript" src="assets/script/jquery-2.2.3.min.js"></script>
    </head>



    <body>
    <div id="line_top_x"></div>
    <div id="Temperatura" style="height: 470px; max-width: 1120px; margin: 0px auto;"></div>
    <div id="Humedad" style="height: 470px; max-width: 1120px; margin: 0px auto;"></div>
    <div id="Luz" style="height: 470px; max-width: 1120px; margin: 0px auto;"></div>
    </body>
    
    <footer id="main-footer">
    <p>&copy; 2021 Todos los derechos reservados:p</p>
</footer> 
</html>



