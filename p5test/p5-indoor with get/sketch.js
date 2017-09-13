var rssi1 =0 ,rssi2=0 ,rssi3=0,rssiToDist1=0,rssiToDist2=0,rssiToDist3=0;
var i=0;
var x=0;
var url="http://wisdomkraft.com/wisdomkraft.com/prudence/Indoor_nav/rssi_data_to_json.php";
var output;
var p1 ,p2 ,p3;  
var d1 = 0,d2 = 0,d3 = 0,r1 = 0,r2 = 0,r3 = 0;
var target;
var lerper;  
var calculated;   
var pixelBuffer=10;

function setup(){
    setInterval(request,1000);//to restart the loop
//    createCanvas(760,625);
//    
//    p1 = new p5.Vector(10, 10);
//    p2 = new p5.Vector(10, height-10);
//    p3 = new p5.Vector(width-10, height/2);
    createCanvas(1500,1000);
    
    p1 = new p5.Vector(382,200);
    p2 = new p5.Vector(382,800);
    p3 = new p5.Vector(1118, height/2);
    lerper=new p5.Vector(0,0);

}
function request(){
    httpDo(url,"GET","json",data);
}
function data(responce)
{
    output = responce;
 rssi1 =output[0].R1;
 rssi2 =output[0].R2;
 rssi3 =output[0].R3;
 rssiToDist1=((((rssi1 - 32.0) / 25.0)*1000)/2);
 rssiToDist2=((((rssi2 - 32.0) / 25.0)*1000)/2);
 rssiToDist3=((((rssi3 - 32.0) / 25.0)*1000)/2);
     r1=rssiToDist1;
     r2=rssiToDist2;
     r3=rssiToDist3;

}

function draw()
{
 background(250);
    drawGrid();
    
    rectMode(CENTER);
    fill(240);
	rect(width/2, height/2, 760, 625); 
    
    if(output){
        print(output);
        print(r1);
        print(r2);
        print(r3);
        print(i+x);
        x++;
    }
    
  // background(250);
    
calculated = trilaterate(p1, p2, p3, r1, r2, r3);
print(calculated);
    target=new p5.Vector(calculated.x, calculated.y);

lerper.lerp(target, 0.02);
    
print("calculated.x="+calculated.x+" calculated.y="+calculated.y);
print("target="+target);

    strokeWeight(1);
  
noFill();
stroke(180, 250, 180);strokeWeight(3);
line(p1.x, p1.y, target.x, target.y);
line(p2.x, p2.y, target.x, target.y);
line(p3.x, p3.y, target.x, target.y);

stroke(180, 180, 250);strokeWeight(3);
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
ellipse(target.x, target.y, 20, 20);

}
//function mousePressed() {
//save("trilateration.png");
//}

function drawGrid() {
	stroke(200);
	fill(0);
    strokeWeight(1);
	for (var x=-width; x < width; x+=40) {
		line(x, -height, x, height);
		text(x, x+1, 12);
	}
	for (var y=-height; y < height; y+=40) {
		line(-width, y, width, y);
		text(y, 1, y+12);
	}
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