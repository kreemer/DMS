function getInstructions() {
    console.log('getting instructions');
    var route = Routing.generate('instruction');
    $.getJSON(route, function(data) {
        console.log("Load was performed.");
        var result = math.eval(data.math);
        sendResult(result, data.step, data.id);
        window.setTimeout(getInstructions, 500);
    });
}
function sendResult(data, step, id) {
    var result = { "step": step, "data": data, "success": true, "id": id }
    console.log(result);
    $.post(Routing.generate('result'), result);
}