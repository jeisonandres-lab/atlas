
document.addEventListener('DOMContentLoaded', function() {
  fetch('chart.php') // Reemplaza esto con la ruta correcta a tu script PHP
      .then(response => response.json())
      .then(data => {
          const playerNames = data.map(item => item.personal);
          const scores = data.map(item => item.firma);

          const ctx = document.getElementById('scoreChart').getContext('2d');
          const scoreChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: playerNames, // Usar playerNames para las etiquetas
                  datasets: [{
                      label: 'Scores', // Etiqueta para el conjunto de datos
                      data: scores, // Usar scores para los datos
                      borderWidth: 1,
                      borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(54, 162, 235)',
                          'rgb(153, 102, 255)',
                          'rgb(201, 203, 207)'
                      ],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(201, 203, 207, 0.2)'
                      ]
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });
      })
      .catch(error => console.error('Error fetching data:', error));
});