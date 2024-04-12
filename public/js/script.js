$(".fa-bars").on("click", myFunction);

function myFunction() {
    var x = document.querySelector(".mobile-navigation");
    if (x.className === "mobile-navigation") {
      x.className += " responsive";
    } else {
      x.className = "mobile-navigation";
    }
  }

