import processing.net.*;

Client c;
String data;

//-------------------------------------------------------------
// setup. Requests the php page and passes it "Id=3" 
// as parameter.
//-------------------------------------------------------------
void setup() {
size(60, 60);
stroke( 255 );
c = new Client( this, "localhost", 90 );
c.write("GET /~xampp/htdocs/pde.php?Id=3\n"); 
c.write("Host:localhost:90\n\n"); 
frameRate( 1 );
}


//-------------------------------------------------------------
// draw: display contents returned by php, or "no data"
//-------------------------------------------------------------
void draw() {
if (c.available() > 0) { 
data = c.readString(); 
println( "data = " + data );
}
else
println( "no data" );
}