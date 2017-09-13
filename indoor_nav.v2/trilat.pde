import processing.serial.*;
PVector p1, p2, p3;            // beacons
float d1, d2, d3, r1, r2, r3;  // distances
PVector target;                // made up point that we are trying to locate
PVector lerper;                // the actual place drawn as we lerp towards the target
PVector calculated;            // calculated point
int pixelBuffer;               // limits how close the false target can get to the edge of the sketch (for testing)
Serial myPort;
/**
 * Initialise the dimensions of the arena, and the locations of the beacons
 */
void setup() {
{
  String portName = "COM7";
    
   myPort = new Serial(this, portName, 115200);
}
  //set the dimensions of the beacons
  size(700, 700);

  //can use this to slow it down if you like...
  //frameRate(20);

  //set up the positions of the known beacons
  p1 = new PVector(width/2, 10);
  p2 = new PVector(10, height-10);
  p3 = new PVector(width-10, height-10);

  //set up initial values for lerper and target
  pixelBuffer = myPort.read();
  target = new PVector(random(pixelBuffer, width - pixelBuffer), random(pixelBuffer, height - pixelBuffer));
  lerper = target;
}

/**
 * Calculates a random position, works out the distances to the anchors, 
 *  works out the new position using trilateration, and draws both for comparison
 */
void draw() {
if(myPort.available()>0)
  {
  println(myPort.read());
  delay(1000);
  }
  else
  {
  println("no devices found");
  }
  //reset the frame
  background(250);

  //make up a new target if needed
  if (lerper.dist(target) < 1) target = new PVector(random(pixelBuffer, width - pixelBuffer), random(pixelBuffer, height - pixelBuffer));

  //move the lerper towards the target
  lerper.lerp(target, 0.2);

  //get the distance between the current lerper position and each beacon
  // (mimicing distance calcs from the beacons)
  r1 = lerper.dist(p1);
  r2 = lerper.dist(p2);
  r3 = lerper.dist(p3);

  //calculate where we think the target is
  calculated = trilaterate(p1, p2, p3, r1, r2, r3);
  println(calculated);

  //draw lines to connect the beacons and the lerper 
  noFill();
  stroke(180, 250, 180);
  line(p1.x, p1.y, lerper.x, lerper.y);
  line(p2.x, p2.y, lerper.x, lerper.y);
  line(p3.x, p3.y, lerper.x, lerper.y);

  //draw spherical radii onto the beacons
  stroke(180, 180, 250);
  ellipse(p1.x, p1.y, r1*2, r1*2);
  ellipse(p2.x, p2.y, r2*2, r2*2);
  ellipse(p3.x, p3.y, r3*2, r3*2);

  //draw the beacons in blue
  noStroke();
  fill(0, 0, 255);
  ellipse(p1.x, p1.y, 20, 20);
  ellipse(p2.x, p2.y, 20, 20);
  ellipse(p3.x, p3.y, 20, 20);

  //draw the lerper in green
  fill(0, 255, 0);
  ellipse(lerper.x, lerper.y, 30, 30);

  //draw the calculated result in red
  fill(255, 0, 0);
  ellipse(calculated.x, calculated.y, 20, 20);
}

void mousePressed(){
  save("trilateration.png");
}


/**
 * Trilateration algorithm as per:
 *  http://en.wikipedia.org/wiki/Trilateration
 *  http://shiffman.net/p5/trilateration2/trilateration.pde
 *  http://gis.stackexchange.com/questions/66/trilateration-using-3-latitude-and-longitude-points-and-3-distances
 *
 * In three-dimensional geometry, when it is known that a point lies on the surfaces of three spheres, 
 *  then the centers of the three spheres along with their radii provide sufficient information to 
 *  narrow the possible locations down to no more than two.
 *
 * To simplify the maths, this algorithm converts to a coordinate system such that:
 * - all three centers are in the plane z = 0
 * - the sphere center, P1, is at the origin
 * - the sphere center, P2, is on the x-axis
 *
 * It then performs the trlateration and then converts it all back to give the final result 
 *
 * This has been directly translated from Python, and the original python code is included line by line for clarity
 *
 * NOTE: When translating, even though you wouldn't think it, numpy.linalg.norm() is the equivalent of PVector.mag().
 */
private PVector trilaterate(PVector p1, PVector p2, PVector p3, float r1, float r2, float r3) {
  
  //ex = (P2 - P1)/(numpy.linalg.norm(P2 - P1))
  PVector ex = PVector.div(PVector.sub(p2, p1), PVector.sub(p2, p1).mag());
  //println(ex);
  
  //i = dot(ex, P3 - P1)
  float i = PVector.dot(ex, PVector.sub(p3, p1));
  //println(i);
  
  //ey = (P3 - P1 - i*ex)/(numpy.linalg.norm(P3 - P1 - i*ex))
  PVector ey = PVector.div(PVector.sub(PVector.sub(p3, p1), PVector.mult(ex, i)),
    PVector.sub(PVector.sub(p3, p1), PVector.mult(ex, i)).mag());
  //println(ey);
  
  //ez = numpy.cross(ex,ey)
  PVector ez = new PVector();
  PVector.cross(ex, ey, ez);
  //println(ez);
  
  //d = numpy.linalg.norm(P2 - P1)
  float d = PVector.sub(p2, p1).mag();
  //println(d);
  
  //j = dot(ey, P3 - P1)
  float j = PVector.dot(ey, PVector.sub(p3, p1));
  //println(j);
  
  //x = (pow(DistA,2) - pow(DistB,2) + pow(d,2))/(2*d)
  float x = (pow(r1, 2) - pow(r2, 2) + pow(d, 2))/(2*d);
  //println(x);
  
  //y = ((pow(DistA,2) - pow(DistC,2) + pow(i,2) + pow(j,2))/(2*j)) - ((i/j)*x)
  float y = ((pow(r1, 2) - pow(r3, 2) + pow(i, 2) + pow(j, 2))/(2*j)) - ((i/j)*x);
  //println(y);
  
  //The abs here is a bit of a bodge to prevent a negative number going to sqrt
  //  Really need to look into this and deal with it better at some point...
  //z = sqrt(pow(DistA,2) - pow(x,2) - pow(y,2))
  //float z = sqrt(pow(r1, 2) - pow(x, 2) - pow(y, 2));
  float z  = sqrt(abs(pow(r1, 2) - pow(x, 2) - pow(y, 2)));
  //println(z);

  //triPt = P1 + x*ex + y*ey + z*ez
  ex.mult(x);
  //println(ex);
  ey.mult(y);
  //println(ey);
  ez.mult(z);
  //println(ez);
  return PVector.add(PVector.add(PVector.add(p1, ex), ey), ez);
}