<?php
// Değişkenleri Tanımlayalım
$x=array("1"=>0,
        "2"=>1,
        "3"=>1);

$w[1][4]=0.1;
$w[1][5]=-0.4;
$w[2][4]=0.3;
$w[2][5]=0.1;
$w[3][4]=0.4;
$w[3][5]=0.3;
$w[4][6]=0.3;
$w[5][6]=0.3;

$qsabit=1;

$q[4]=0.3;
$q[5]=-0.2;
$q[6]=0.2;

$geridagitmasabiti=0.8;

$z=1;

// ANN Algoritması Başlıyor
for ($i=0; $i < 1000 ; $i++) {

// Y4 değeri hesaplanıyor
$y4giris=($x[1]*$w[1][4])+($x[2]*$w[2][4])+($x[3]*$w[3][4])+($qsabit*$q[4]);
$y4girisexp=-1*$y4giris;
$y4cikis=1/(1+exp($y4girisexp));

// Y5 değeri hesaplanıyor
$y5giris=($x[1]*$w[1][5])+($x[2]*$w[2][5])+($x[3]*$w[3][5])+($qsabit*$q[5]);
$y5girisexp=-1*$y5giris;
$y5cikis=1/(1+exp($y5girisexp));

// Y6 değeri hesaplanıyor
$y6giris=($y4cikis*$w[4][6])+($y5cikis*$w[5][6])+($qsabit*$q[6]);
$y6girisexp=-1*$y6giris;
$y6cikis=1/(1+exp($y6girisexp));

$zdegeri[$i]=$y6cikis;

// Hata payları bulunuyor
$e[4]=$y4cikis*($z-$y4cikis)*($z-$y4cikis);
$e[5]=$y5cikis*($z-$y5cikis)*($z-$y5cikis);
$e[6]=$y6cikis*($z-$y6cikis)*($z-$y6cikis);

// Hata payı kayıda alınıyor
$hata_payi[$i]=$e[6];

// Hatayı Geri Dağıtempnam
$w[1][4]=$w[1][4]+($geridagitmasabiti*$e[4]*$x[1]);
$w[1][5]=$w[1][5]+($geridagitmasabiti*$e[5]*$x[1]);
$w[2][4]=$w[2][4]+($geridagitmasabiti*$e[4]*$x[2]);
$w[2][5]=$w[2][5]+($geridagitmasabiti*$e[5]*$x[2]);
$w[3][4]=$w[3][4]+($geridagitmasabiti*$e[4]*$x[3]);
$w[3][5]=$w[3][5]+($geridagitmasabiti*$e[5]*$x[3]);
$w[4][6]=$w[4][6]+($geridagitmasabiti*$e[6]*$y4cikis);
$w[5][6]=$w[5][6]+($geridagitmasabiti*$e[6]*$y5cikis);

$q[4]=$q[4]+($geridagitmasabiti*$e[4]*$qsabit);
$q[5]=$q[5]+($geridagitmasabiti*$e[5]*$qsabit);
$q[6]=$q[6]+($geridagitmasabiti*$e[6]*$qsabit);


}// For sonu

// Garifiği Cızdırıyoruz
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <title>Yapay Sinir Ağları Hata Payı</title>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
 </head>
 <body>
  <div id="container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
 </body>
 <script type="text/javascript">
 Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Yapay Sinir Ağları Hata Payı'
    },
    subtitle: {
        text: 'Hazırlayan : Caner Ergez'
    },
    xAxis: {
        allowDecimals: false,
        labels: {
            formatter: function () {
                return this.value; // clean, unformatted number for year
            }
        }
    },
    yAxis: {
        title: {
            text: 'Hata Payı'
        },
        labels: {
            formatter: function () {
                return this.value;
            }
        }
    },
    plotOptions: {
        area: {
            pointStart: 1,
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
     name: 'Z Çıkış Değeri',
     data: [<?php echo join($zdegeri,','); ?>]
    },{
     name: 'Hata Payı',
     data: [<?php echo join($hata_payi,','); ?>]
    }]
 });
 </script>
</html>
