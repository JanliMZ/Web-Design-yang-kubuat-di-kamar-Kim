function appendToDisplay(value) {
    document.getElementById('display').value += value;
}

function clearDisplay() {
    document.getElementById('display').value = '';
}

function calculate() {
    try {
        let result = eval(document.getElementById('display').value);
        document.getElementById('display').value = result;
    } catch(e) {
        document.getElementById('display').value = 'Error';
    }
}

var timestamp = Date.now();
document.getElementById("demo").innerHTML = "Timestamp: " + timestamp;

