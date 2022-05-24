$(document).ready(function() {
  grafica();
  grafica1();
});

function grafica() {
  $.ajax({
    url: "grafica.php",
    method: "POST",
    success: function(data) {
      var mes = [];
      var total = [];
      var obj = jQuery.parseJSON(data);

      for (var i in obj) {
        mes.push(obj[i].mes);
        total.push(obj[i].total);
      }

      var chartdata = {
        labels: mes,
        datasets: [{
          label: 'UNIDADES VENDIDAS',
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(95, 172, 136, 0.2)',
            'rgba(95, 105, 136, 0.2)',
            'rgba(255, 57, 218, 0.2)',
            'rgba(0, 255, 0, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(95, 172, 136, 1)',
            'rgba(95, 105, 136, 1)',
            'rgba(255, 57, 218, 1)',
            'rgba(0, 255, 0, 1)'
          ],
          //backgroundColor:'rgba(54, 162, 235, 0.2)',
          //borderColor:'rgba(54, 162, 235, 1)',
          borderWidth: 1.2,
          data: total,
        }]
      };

      var ctx = $("#myChart");

      var barGraph = new Chart(ctx, {
        type: 'horizontalBar',
        data: chartdata,
        options: {
          title: {
            display: true,
            text: 'PRODUCTOS MAS VENDIDOS'
          },
          responsive: true,
        },
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
}

function grafica1() {
  $.ajax({
    url: "grafica1.php",
    method: "POST",
    success: function(data) {
      var mes = [];
      var total = [];
      var obj = jQuery.parseJSON(data);

      for (var i in obj) {
        mes.push(obj[i].mes);
        total.push(obj[i].total);
      }

      var chartdata = {
        labels: mes,
        datasets: [{
          label: 'TOTAL VENTAS',
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(95, 172, 136, 0.2)',
            'rgba(95, 105, 136, 0.2)',
            'rgba(255, 57, 218, 0.2)',
            'rgba(0, 255, 0, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(95, 172, 136, 1)',
            'rgba(95, 105, 136, 1)',
            'rgba(255, 57, 218, 1)',
            'rgba(0, 255, 0, 1)'
          ],
          //backgroundColor:'rgba(54, 162, 235, 0.2)',
          //borderColor:'rgba(54, 162, 235, 1)',
          borderWidth: 1.2,
          data: total,
        }]
      };

      var ctx = $("#myChart1");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
        options: {
          title: {
            display: true,
            text: 'VENTAS POR MES'
          },
          responsive: true,
        },
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
}
