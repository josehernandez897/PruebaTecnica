<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Prueba-Tecnica</title>
</head>

<body>
    <h1>PruebaTecnica</h1>

    {{-- svc/properties.csv --}}

    <button onclick="getData()">Crear usuario y Importar datos masivos</button>
    <br/>
    <br/>
    <br/>
    <?php
    echo '<table border="1" id="table">';

    $start_row = 1;

    if (($csv_file = fopen('svc/properties.csv', 'r')) !== false) {
        while (($read_data = fgetcsv($csv_file, 1000, ',')) !== false) {
            $column_count = count($read_data);
            echo '<tr>';
            $start_row++;
            for ($c = 0; $c < $column_count; $c++) {
                echo '<td>' . $read_data[$c] . '</td>';
            }
            echo '</tr>';
        }

        fclose($csv_file);
    }

    echo '</table>';
    ?>



    <script src="{{ asset('/js/main.js') }}"></script>
</body>

</html>
