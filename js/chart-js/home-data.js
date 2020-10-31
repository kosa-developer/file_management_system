$(document).ready(function() {
    var MONTHS=["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var config= {
        type:'line', data: {
            labels:["January", "February", "March", "April", "May", "June", "July"], datasets:[ {
                label: "New Patients", backgroundColor: window.chartColors.red, borderColor: window.chartColors.red, data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()], fill: false,
            }
            , {
                label: "Old Patients", fill: false, backgroundColor: window.chartColors.blue, borderColor: window.chartColors.blue, data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
            }
            ]
        }
        , options: {
            responsive:true, title: {
                display: true, text: 'HOSPITAL SURVEY'
            }
            , tooltips: {
                mode: 'index', intersect: false,
            }
            , hover: {
                mode: 'nearest', intersect: true
            }
            , scales: {
                xAxes:[ {
                    display:true, scaleLabel: {
                        display: true, labelString: 'Month'
                    }
                }
                ], yAxes:[ {
                    display:true, scaleLabel: {
                        display: true, labelString: 'Patients'
                    }
                }
                ]
            }
        }
    }
    ;
    var ctx=document.getElementById("chartjs_line").getContext("2d");
    window.myLine=new Chart(ctx, config);
}

);

$(document).ready(function() {
	var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    var chartColors = window.chartColors;
    var color = Chart.helpers.color;
    var config = {
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    color(chartColors.red).alpha(0.5).rgbString(),
                    color(chartColors.orange).alpha(0.5).rgbString(),
                    color(chartColors.yellow).alpha(0.5).rgbString(),
                    color(chartColors.green).alpha(0.5).rgbString(),
                    color(chartColors.blue).alpha(0.5).rgbString(),
                ],
                label: 'My dataset' // for legend
            }],
            labels: [
                "Red",
                "Orange",
                "Yellow",
                "Green",
                "Blue"
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Polar Area Chart'
            },
            scale: {
              ticks: {
                beginAtZero: true
              },
              reverse: false
            },
            animation: {
                animateRotate: false,
                animateScale: true
            }
        }
    };

        var ctx = document.getElementById("chartjs_polar");
        window.myPolarArea = Chart.PolarArea(ctx, config);

	});