<!DOCTYPE html>
<html lang="en">
<head>
    <title>Taken</title>


    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Light">

    <meta name="theme-color" content="#26292e">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>


    <script src=" https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="css/themes/dark/light.css" rel="stylesheet">
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        canvas {
            background-color: #ffffff;

        }

        body, html {
            height: 100%;
        }


    </style>
</head>
<body>



<section>
    <div class="container" style="margin-bottom: 100px;">
        <h2 class="text-center ">Last 3 weeks</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row h-100 justify-content-center align-items-center">
                    <canvas id="canvas_week"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-primary text-white" >
    <div class="container" style="margin-bottom: 100px;padding-top:50px; padding-bottom:50px;">
        <div class="text-center mt-4">
            <h2 class="text-uppercase text-white">About</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 ml-auto">
                <p class="lead">Complete <?= $completeEachWeek ?> each week</p>
                <p class="lead">Completed this week <?= $taskDifference ?> </p>
                <p class="lead">On track
                    <span style="font-size: -webkit-xxx-large;">
                    <?php if ($taskDifference > $completeEachWeek): ?>
                        <i class="fas fa-crown text-success"></i>
                    <?php else: ?>
                        <i class="fas fa-times text-danger" ></i>
                    <?php endif ?>
                    </span>
                </p>
                <p class="lead">Total left <?= $currentOpenTasks ?> </p>
            </div>
            <div class="col-lg-4 mr-auto">
                <p class="lead">Last checked: <?= $lastChecked->format('d-m-Y') ?></p>
                <p class="lead">Current week: <?= $currentWeekNumber ?></p>
                <p class="lead">Weeks left <?= $weeksLeft ?> </p>
            </div>
        </div>

    </div>
</section>

<section>
    <div class="container" style="margin-bottom: 100px;">
        <h2 class="text-center ">Past 5 days</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row h-100 justify-content-center align-items-center">
                    <canvas id="canvas_day"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="">
    <div class="container " style="margin-top: 100px; margin-bottom: 100px;">
        <h2 class="text-center ">Year</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row h-100 justify-content-center align-items-center">
                    <canvas id="canvas_year"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>





</body>
<script>
    'use strict';

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };


    var config = {
        type: 'line',
        data: {},
        options: {
            responsive: true,
            title: {
                display: false,
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Day'
                    }
                }],
                yAxes: [{
                    display: true,
                    ticks: {

                        stepSize: 1
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Number of tasks'
                    }
                }]
            }
        }
    };

    window.onload = function () {
        var day =  Object.assign({}, config);
        day.data = {
            labels: [<?php echo implode(',', array_map(function ($value) {
                return "'" . $value . "'";
            }, array_keys($dataDay))) ?>],
            datasets: [{
                label: 'Tasks',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [
                    <?php echo implode(',', array_values($dataDay)) ?>
                ],
                fill: false,
            },
            ]
        };


        var week =  Object.assign({}, config);
        week.data = {
            labels: [<?php echo implode(',', array_map(function ($value) {
                return "'" . $value . "'";
            }, array_keys($dataWeek))) ?>],
            datasets: [{
                label: 'Tasks',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [
                    <?php echo implode(',', array_values($dataWeek)) ?>
                ],
                fill: false,
            },
            ]
        };

        var year =  Object.assign({}, config);
        year.data = {
            labels: [<?php echo implode(',', array_map(function ($value) {
                return "'" . $value . "'";
            }, array_keys($dataYear))) ?>],
            datasets: [{
                label: 'Tasks',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [
                    <?php echo implode(',', array_values($dataYear)) ?>
                ],
                fill: false,
            },
            ]
        };

        new Chart(document.getElementById('canvas_day').getContext('2d'), day);
        new Chart(document.getElementById('canvas_week').getContext('2d'), week);
        new Chart(document.getElementById('canvas_year').getContext('2d'), year);
    };


</script>
</html>