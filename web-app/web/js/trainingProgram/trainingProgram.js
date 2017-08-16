$(document).ready(function () {

    $dataContainer = $("#dataContainer");



    $.getJSON("/catalogue-formations", function (data) {
        trainingProgramOutputJSONString="";
        data.forEach(function (item) {

            trainingProgramOutputJSONString += "<tr><td>" + item.id + "</td><td>" + item.label + "</td><td>" + item.description + "</td><tr>";

        });

        $dataContainer.html(trainingProgramOutputJSONString);

    })


});