dms_processing = true;
function getInstructions() {
    if (!dms_processing) {
        console.log('won`t do anything, master!');
        return;
    }
    console.log('getting instructions');
    var route = Routing.generate('instruction');
    $.getJSON(route, function(data) {
        console.log("Load was performed.");
        var start = new Date();
        var result = math.eval(data.math);
        var duration = new Date() - start;
        var resultObj = { "step": data.step, "data": result, "success": true, "id": data.id, "duration": duration }
        $.post(Routing.generate('result'), resultObj);
        window.setTimeout(getInstructions, 500);
    });
}