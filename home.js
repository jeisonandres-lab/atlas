const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
// document.addEventListener('DOMContentLoaded', function() {
//   fetch('chart.php') // Replace this with the actual path to your PHP script
//       .then(response => response.json())
//       .then(data => {
//           const playerNames = data.map(item => item.personal);
//           const scores = data.map(item => item.firma);

//           const ctx = document.getElementById('scoreChart').getContext('2d');
//           const scoreChart = new Chart(ctx, {
//               type: 'bar',
//               data: {
//                 labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'], // Use playerNames for the labels
//                   datasets: [{
//                       label: scores, // Label for the dataset
//                       data: [12,12,34,12], // Use scores for the data
//                       borderWidth: 1,
//                       borderColor: [
//                         'rgb(255, 99, 132)',
//                         'rgb(255, 159, 64)',
//                         'rgb(255, 205, 86)',
//                         'rgb(75, 192, 192)',
//                         'rgb(54, 162, 235)',
//                         'rgb(153, 102, 255)',
//                         'rgb(201, 203, 207)'
//                       ],
//                       backgroundColor: [
//                         'rgba(255, 99, 132, 0.2)',
//                         'rgba(255, 159, 64, 0.2)',
//                         'rgba(255, 205, 86, 0.2)',
//                         'rgba(75, 192, 192, 0.2)',
//                         'rgba(54, 162, 235, 0.2)',
//                         'rgba(153, 102, 255, 0.2)',
//                         'rgba(201, 203, 207, 0.2)'
//                       ],
//                   }]
//               },
//               options: {
//                   scales: {
//                       y: {
//                           beginAtZero: true
//                       }
//                   },
//                   animations: {
//                     tension: {
//                       duration: 1000,
//                       easing: 'lineal',
//                       from: 1,
//                       to: 0,
//                       loop: false
//                     }
//                   },
//               }
//           });
//       })
//       .catch(error => console.error('Error fetching data:', error));
// });