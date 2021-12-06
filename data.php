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
    $point = array("valorx" => $row[0], "valory" => $row[1], "valorz" => $row[2], "valork" => $row[3]);
    array_push($data_points, $point);
}
echo json_encode($data_points);

mysqli_close($enlace);
?>