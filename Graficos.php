<?php
include_once("header.php")
?>

<?php
include_once("header.php")
?>
<html>
    <head>
        <script type="text/javascript">
            window.onload = function () {
                var dataLength = 0;
                var data = [];
                $.getJSON("data.php", function (result) {
                    dataLength = result.length;
                    for (var i = 0; i < dataLength; i++) {
                        data.push({
                            x: parseInt(result[i].valorx),
                            y: parseInt(result[i].valory)
                        });
                    }
                    ;
                    chart.render();
                });
                var chart = new CanvasJS.Chart("chart", {
                    title: {
                        text: "Valores X vs. Valores Y"
                    },
                    axisX: {
                        title: "Valores X",
                    },
                    axisY: {
                        title: "Valores Y",
                    },
                    data: [{type: "line", dataPoints: data}],
                });
            }
        </script>
        <script type="text/javascript" src="assets/script/canvasjs.min.js"></script>
        <script type="text/javascript" src="assets/script/jquery-2.2.3.min.js"></script>
    </head>
    <body>
        <div id="chart">
        </div>
    </body>
    
    <footer id="main-footer">
    <p>&copy; 2021 Todos los derechos reservados:p</p>
</footer> 
</html>

