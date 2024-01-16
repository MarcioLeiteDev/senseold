

function goTo(element , speed){
    var href = element.attr('href');
    var top = $(href).offset().top;
    $("html,body").animate({scrollTop : top }, speed);
};
  
$( "a" ).click(function() {
  goTo($(this) , 500);
});


$(document).ready(function(){

            $(".js_box").animate({"left": 800}, 1000, function () {
           
        })
            $(".js_box2").animate({"top": 150}, 1000, function () {
           
        })

});

$(document).ready(function(){
    
   var app = document.getElementById('app');

var typewriter = new Typewriter(app, {
    loop: true
});

typewriter.typeString('Cidadania Italiana, Portuguesa e Espanhola')
    .pauseFor(2500)
    .deleteAll()
    .typeString('Tradução e Versão nos idiomas')
    .pauseFor(2500)
    .deleteChars(29)
    .typeString('Português, Inglês, Espanhol, Italiano, Francês, Alemão, Japonês e Chinês.')
    .pauseFor(2500)
    .start();
    
});






    
    
   



    




