
/* global ExposureLevelObject */

var defaultColors = [
    window.chartColors.green,
    window.chartColors.blue,
    window.chartColors.red,
    window.chartColors.purple,
    window.chartColors.yellow,
    window.chartColors.lime,
    window.chartColors.magenta,
    window.chartColors.silver,
    window.chartColors.orange,
    window.chartColors.brown,
    window.chartColors.maroon,
    window.chartColors.olive,
],defaultColors2 = [
    window.chartColors.yellow,
    window.chartColors.green,
    window.chartColors.orange,
    window.chartColors.brown,
];
$(document).ready(function () {
    var data_set = [],labels=[];
    
    for (var i = 0; i < uniquedynamicQuestionsArray.length; i++) {
       
        data_set.push(uniquedynamicQuestionsArray[i].category_data);
        labels.push(uniquedynamicQuestionsArray[i].category_name);
    }
    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: "Staff",
                    fill: false,
                    backgroundColor: window.chartColors.purple,
                    borderColor: window.chartColors.purple,
                    data: data_set,
                }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'Answers'
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
                            labelString: 'Answers'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Staff'
                        }
                    }]
            }
        }
    };
    var ctx = document.getElementById("chartjs_dynamecQuestion").getContext("2d");
    window.myLine = new Chart(ctx, config);
});



$(document).ready(function () {
    var data_set = [],labels=[];
    
    for (var i = 0; i < uniquequestion119Array.length; i++) {
       
        data_set.push(uniquequestion119Array[i].category_data);
        labels.push(uniquequestion119Array[i].category_name);
    }
    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: "Staff",
                    fill: false,
                    backgroundColor: window.chartColors.purple,
                    borderColor: window.chartColors.purple,
                    data: data_set,
                }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'Staff Ratings'
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
                            labelString: 'Rates'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Staff'
                        }
                    }]
            }
        }
    };
    var ctx = document.getElementById("chartjs_q19").getContext("2d");
    window.myLine = new Chart(ctx, config);
});

$(document).ready(function () {
    var data_set = [],labels=[];
    
    for (var i = 0; i < uniquequestion18Array.length; i++) {
       
        data_set.push(uniquequestion18Array[i].category_data);
        labels.push(uniquequestion18Array[i].category_name);
    }
    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: "Staff",
                    fill: false,
                    backgroundColor: window.chartColors.purple,
                    borderColor: window.chartColors.purple,
                    data: data_set,
                }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'PATIENTS RECEIVED'
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
                            labelString: 'Answers'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Staff'
                        }
                    }]
            }
        }
    };
    var ctx = document.getElementById("chartjs_q18").getContext("2d");
    window.myLine = new Chart(ctx, config);
});

$(document).ready(function () {
    //uniqueCategoriesData
    for (var i = 0; i < uniqueCategoriesData.length; i++) {
        var category_data_got=uniqueCategoriesData[i].category_data;
        var data_labels=[],category_data=[];
        for(var y=0;y<category_data_got.length;y++){
            data_labels.push(category_data_got[y].Category);
            category_data.push(category_data_got[y].Survey);
        }
        var config = {
        type: 'bar',
        data: {
            labels: data_labels,
            datasets: [{
                    label:uniqueCategoriesData[i].category_name,
                    backgroundColor: defaultColors[i],
                    borderColor:defaultColors[i],
                    data: category_data,
                    fill: false,
                }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Questions'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Staff'
                        }
                    }]
            }
        }
    };
    var ctx = document.getElementById("chartjs_predictionfactors"+uniqueCategoriesData[i].category_id).getContext("2d");
    window.myLine = new Chart(ctx, config);
    }
    
});



$(document).ready(function () {
    var data_labels = [], data_set = [], colors = [];
    for (var i = 0; i < uniquequestion119Array_pie.length; i++) {
        data_set.push(uniquequestion119Array_pie[i].category_data);
        data_labels.push(uniquequestion119Array_pie[i].category_name);
        colors.push(defaultColors[i]);
    }

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                    data: data_set,
                    backgroundColor: colors,
                    label: 'Dataset 1'
                }],
            labels: data_labels
        },
        options: {
            responsive: true
        }
    };

    var ctx = document.getElementById("chartjs_q19_pie").getContext("2d");
    window.myPie = new Chart(ctx, config);
});



$(document).ready(function () {
    var data_labels = [], data_set = [], colors = [];
    for (var i = 0; i < uniquequestion18Array_pie.length; i++) {
        data_set.push(uniquequestion18Array_pie[i].category_data);
        data_labels.push(uniquequestion18Array_pie[i].category_name);
        colors.push(defaultColors[i]);
    }

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                    data: data_set,
                    backgroundColor: colors,
                    label: 'Dataset 1'
                }],
            labels: data_labels
        },
        options: {
            responsive: true
        }
    };

    var ctx = document.getElementById("chartjs_q18_pie").getContext("2d");
    window.myPie = new Chart(ctx, config);
});

$(document).ready(function () {
    var data_labels = [], data_set = [], colors = [];
    for (var i = 0; i < uniquequestion18Array_pie.length; i++) {
        data_set.push(uniquequestion18Array_pie[i].category_data);
        data_labels.push(uniquequestion18Array_pie[i].category_name);
        colors.push(defaultColors[i]);
    }

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                    data: data_set,
                    backgroundColor: colors,
                    label: 'Dataset 1'
                }],
            labels: data_labels
        },
        options: {
            responsive: true
        }
    };

    var ctx = document.getElementById("chartjs_q18_pie").getContext("2d");
    window.myPie = new Chart(ctx, config);
});


$(document).ready(function () {
    var data_labels = [], data_set = [], colors = [];
    for (var i = 0; i < uniquedynamicQuestionsArray_pie.length; i++) {
        data_set.push(uniquedynamicQuestionsArray_pie[i].category_data);
        data_labels.push(uniquedynamicQuestionsArray_pie[i].category_name);
        colors.push(defaultColors[i]);
    }

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                    data: data_set,
                    backgroundColor: colors,
                    label: 'Dataset 1'
                }],
            labels: data_labels
        },
        options: {
            responsive: true
        }
    };

    var ctx = document.getElementById("chartjs_dynamecQuestion_pie").getContext("2d");
    window.myPie = new Chart(ctx, config);
});


$(document).ready(function () {
     for (var i = 0; i < uniqueCategoriesData.length; i++) {
        var category_data_got=uniqueCategoriesData[i].category_data;
        var data_labels=[],category_data=[];
        for(var y=0;y<category_data_got.length;y++){
            data_labels.push(category_data_got[y].Category);
            category_data.push(category_data_got[y].Survey);
        }}
    var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var color = Chart.helpers.color;
    var barChartData = {
        labels: data_labels,
        datasets: [{
                label: 'New Patients',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }, {
                label: 'Old Patients',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }]

    };

    var ctx = document.getElementById("general_graphq").getContext("2d");
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Bar Chart'
            }
        }
    });

});



$(document).ready(function () {
    //categoryFactorsData
    var labels = [], data = [], dataSetsData = [], categoriesColors = [], before_data = [], categoryLabels = [];
    for (var i = 0; i < generalquestionArray.length; i++) {
        labels.push(generalquestionArray[i].category_name);
        var category_data_got = generalquestionArray[i].category_data;
        var levelCategories=[];
        for (var x = 0; x < category_data_got.length; x++) {
            if (!categoryLabels.includes(category_data_got[x].Category)) {
                categoryLabels.push(category_data_got[x].Category);
            }
            levelCategories.push(category_data_got[x].Survey);
        }
        dataSetsData.push({
            label: categoryLabels[i],
            backgroundColor: defaultColors[i],
            borderColor: defaultColors[i],
            borderWidth: 1,
            data: levelCategories
        });
    }
    var color = Chart.helpers.color;
    var barChartData = {
        labels: labels,
        datasets: dataSetsData

    };

    var ctx = document.getElementById("general_graph").getContext("2d");
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: false,
                text: 'Bar Chart'
            }
        }
    });

});

$(document).ready(function () {
    var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var config = {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                    label: "New Patients",
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor()
                    ],
                    fill: false,
                }, {
                    label: "Old Patients",
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor()
                    ],
                }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'HOSPITAL SURVEY'
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
                            labelString: 'Month'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Patients'
                        }
                    }]
            }
        }
    };
    var ctx = document.getElementById("chartjs_line").getContext("2d");
    window.myBar = new Chart(ctx, config);
});