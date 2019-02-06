function onClick(element) {
    id = element.id;
    document.location.href="index.php?selected=" + id;
    return element.id;
}
// function onClickAction(element) {
//     id = element.id;
//     document.location.href="index.php?selected=" + id;
//     return element.id;
// }
var expanded = false;

function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}

var expanded2 = false;

function showInputs() {
    var inputs = document.getElementById("inputs");
    if (!expanded) {
        inputs.style.display = "block";
        expanded2 = true;
    } else {
        inputs.style.display = "none";
        expanded2 = false;
    }
}