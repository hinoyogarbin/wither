// ../assets/chart.js

function getRandomTemp(min=25,max=35){return (Math.random()*(max-min)+min).toFixed(1);}
function getRandomHum(min=50,max=80){return (Math.random()*(max-min)+min).toFixed(1);}

const tempData = Array.from({length:6},()=>getRandomTemp());
const humData = Array.from({length:6},()=>getRandomHum());

const tempChart = new Chart(document.getElementById("tempChart"),{
    type:"line",
    data:{labels:["1","2","3","4","5","6"],datasets:[{label:"Temperature (°C)",data:tempData,borderColor:"red",backgroundColor:"rgba(255,0,0,0.2)",fill:true,tension:0.4}]},
    options:{responsive:true,scales:{y:{min:20,max:40}}}
});
const humChart = new Chart(document.getElementById("humChart"),{
    type:"line",
    data:{labels:["1","2","3","4","5","6"],datasets:[{label:"Humidity (%)",data:humData,borderColor:"blue",backgroundColor:"rgba(0,0,255,0.2)",fill:true,tension:0.4}]},
    options:{responsive:true,scales:{y:{min:40,max:90}}}
});

// Update charts and sidebar
function updateCharts(markerId=1){
    const newTemp = getRandomTemp();
    const newHum = getRandomHum();
    tempChart.data.datasets[0].data.shift(); tempChart.data.datasets[0].data.push(newTemp); tempChart.update();
    humChart.data.datasets[0].data.shift(); humChart.data.datasets[0].data.push(newHum); humChart.update();
    document.getElementById("tempValue").innerText = `${newTemp} °C`;
    document.getElementById("humValue").innerText = `${newHum} %`;

    // Add row to log table
    const logTable = document.getElementById("logTable");
    const row = document.createElement("tr");
    row.innerHTML = `<td>${newTemp}</td><td>${newHum}</td><td>${new Date().toLocaleTimeString()}</td>`;
    logTable.prepend(row);

    // Save to DB
    fetch('../sensors/saveSensor.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({marker_id:markerId, temperature:newTemp, humidity:newHum})
    }).then(res=>res.json()).then(data=>console.log("DB Status:",data.status)).catch(err=>console.error(err));
}

setInterval(updateCharts,10000);

// Handle Add Marker Form
document.getElementById('addMarkerForm').addEventListener('submit', e=>{
    e.preventDefault();
    const name = document.getElementById('markerName').value;
    const lat = parseFloat(document.getElementById('markerLat').value);
    const lng = parseFloat(document.getElementById('markerLng').value);

    fetch('../sensors/addMarker.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({marker_name:name, latitude:lat, longitude:lng})
    }).then(res=>res.json()).then(data=>{
        if(data.status==='success'){alert('Marker added!'); myMap.addMarker(lat,lng,name);}
        else alert('Error: '+data.message);
    });
});