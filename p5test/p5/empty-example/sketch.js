// Examples use USGS Earthquake API:
//   https://earthquake.usgs.gov/fdsnws/event/1/#methods
var earthquakes;
function preload() {
  // Get the most recent earthquake in the database
  var url = 'http://www.wisdomkraft.com/wisdomkraft.com/prudence/Indoor_nav/rssi_data_to_arduino.php ';
  httpGet(url, "text", false, function(response) {
    // when the HTTP request completes, populate the variable that holds the
    // earthquake data used in the visualization.
    earthquakes = response;
  }); 
    print(earthquakes);
}

function draw() {
//  if (!earthquakes) {
//    // Wait until the earthquake data has loaded before drawing.
//    return
//  }
//  background(200);
//  // Get the magnitude and name of the earthquake out of the loaded JSON
//  var earthquakeMag = earthquakes.features[0].properties.mag;
//  var earthquakeName = earthquakes.features[0].properties.place;
//  ellipse(width/2, height/2, earthquakeMag * 10, earthquakeMag * 10);
//  textAlign(CENTER);
//  text(earthquakeName, 0, height - 30, width, 30);
  noLoop();
}