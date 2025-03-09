
<!DOCTYPE html>
<html>
<head>
    <title>Generar Excel</title>
</head>
<body>
    <button id="generateButton">Generar Excel</button>

    <script>
        document.getElementById('generateButton').addEventListener('click', function() {
            fetch('generate_excel.php') // Petición GET simple
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'datos_tabla.xlsx';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
        });
    </script>
</body>
</html>
