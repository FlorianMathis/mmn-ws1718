document.addEventListener("DOMContentLoaded", function(event) {
//used the alt tag for this task - could be more elegant by a different way (for instance using siblings and classList.add or classList.remove) ;)
var next = document.getElementById('next');
var previous = document.getElementById('previous');
var image = document.getElementById('image');
var status = document.querySelector('p');
var max = 4;  // read the images folder and count the .jpg's ;)
var nr; //placeholder

function nextimg(){
    if(image.alt != 4){
      nr = parseInt(image.alt)+1;
      image.src="images/image"+nr+".jpg";
    } else {
      nr = 1;
      image.src="images/image1.jpg";
    }
        image.alt = nr;
        status.innerHTML="Bild "+nr+"/"+max;
  }

function previousimg(){
    if(image.alt != 1){
      nr = parseInt(image.alt)-1;
      image.src="images/image"+nr+".jpg";
    } else {
      nr = max;
      image.src="images/image4.jpg";
    }
    image.alt = nr;
    status.innerHTML="Bild "+nr+"/"+max;
}

next.addEventListener('click',nextimg);
previous.addEventListener('click',previousimg);

});