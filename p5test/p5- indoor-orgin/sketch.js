
var p1 ,p2 ,p3;  
var d1 = 0,d2 = 0,d3 = 0,r1 = 0,r2 = 0,r3 = 0;
var target;
var lerper;  
var calculated;   
var pixelBuffer = 0;

function setup() {
createCanvas(700,700);
    
    p1 = new p5.Vector(width/2, 10);
    p2 = new p5.Vector(10, height-10);
    p3 = new p5.Vector(width-10, height-10);

    pixelBuffer = 10;
  target =new p5.Vector(random(pixelBuffer, width - pixelBuffer), random(pixelBuffer,height - pixelBuffer));
  lerper = target;
}


function draw() {
background(250);

     if (lerper.dist(target) < 1) target = new p5.Vector(random(pixelBuffer,width - pixelBuffer),random(pixelBuffer,height - pixelBuffer));

     lerper.lerp(target, 0.2);

  r1 = lerper.dist(p1);
  r2 = lerper.dist(p2);
  r3 = lerper.dist(p3);

  calculated = trilaterate(p1, p2, p3, r1, r2, r3);
  
    
print(calculated);

noFill();
stroke(180, 250, 180);
line(p1.x, p1.y, lerper.x, lerper.y);
line(p2.x, p2.y, lerper.x, lerper.y);
line(p3.x, p3.y, lerper.x, lerper.y);

stroke(180, 180, 250);
ellipse(p1.x, p1.y, r1*2, r1*2);
ellipse(p2.x, p2.y, r2*2, r2*2);
ellipse(p3.x, p3.y, r3*2, r3*2);

noStroke();
fill(0, 0, 255);
ellipse(p1.x, p1.y, 20, 20);
ellipse(p2.x, p2.y, 20, 20);
ellipse(p3.x, p3.y, 20, 20);

fill(0, 255, 0);
ellipse(lerper.x, lerper.y, 30, 30);

fill(255, 0, 0);
ellipse(calculated.x, calculated.y, 20, 20);
}

function mousePressed() {
save("trilateration.png");
}

function trilaterate(p1, p2, p3, r1, r2, r3) {
var ex =  p5.Vector.div(p5.Vector.sub(p2, p1), p5.Vector.sub(p2, p1).mag());

     var i =  p5.Vector.dot(ex,p5.Vector.sub(p3, p1));

     var ey =  p5.Vector.div(p5.Vector.sub(p5.Vector.sub(p3, p1), p5.Vector.mult(ex, i)),
    p5.Vector.sub(p5.Vector.sub(p3, p1), p5.Vector.mult(ex, i)).mag());

     var ez =  new p5.Vector();
  p5.Vector.cross(ex, ey, ez);

     var d =  p5.Vector.sub(p2, p1).mag();

     var j =  p5.Vector.dot(ey, p5.Vector.sub(p3, p1));

     var x =  (pow(r1, 2) -pow(r2, 2)+pow(d, 2))/(2*d);

     var y =  ((pow(r1, 2) - pow(r3, 2) + pow(i, 2) + pow(j, 2))/(2*j)) - ((i/j)*x);

              var z =  sqrt(abs(pow(r1, 2) - pow(x, 2) - pow(y, 2)));

     ex.mult(x);
     ey.mult(y);
     ez.mult(z);
     return p5.Vector.add(p5.Vector.add(p5.Vector.add(p1, ex), ey), ez);
}