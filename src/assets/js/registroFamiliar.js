$(function (){
    let table = new DataTable('#myTable', {
        responsive: true,
        paging: true,
        lengthMenu: [2, 10, 25],
        pageLength: 2,
        language:{
          url: "./IdiomaEspañol.json"
        }
      });
})