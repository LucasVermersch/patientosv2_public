bar2.style.display = "none";
let togg1 = document.getElementById("btn1");
let bar1 = document.getElementById("bar1");
function  verif1() {
if(getComputedStyle(bar1).display !== "none"){
     bar1.style.display = "none";
     bar2.style.display = "block";
      document.getElementById("modifier_class").className = "col-lg-11";
      } else {
        bar1.style.display = "block";
        bar2.style.display = "none";
        document.getElementById("modifier_class").className = "col-lg-9";
      }
 }
 function  verif2() {
 if(getComputedStyle(bar2).display !== "none"){
      bar2.style.display = "none";
      bar1.style.display = "block";
      document.getElementById("modifier_class").className = "col-lg-9";
       } else {
         bar2.style.display = "block";
         bar1.style.display = "none";
          document.getElementById("modifier_class").className = "col-lg-11";
       }
  }
