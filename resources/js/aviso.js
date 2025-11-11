let aviso = document.getElementById("aviso");
let btn =  document.getElementById("btn_aceptar");
let backgroundAviso =  document.getElementById("background-aviso");

    

aviso.classList.add("activo");
backgroundAviso.classList.add("activo");

btn.addEventListener("click",()=>{

    aviso.classList.add("efecto");
    setTimeout(()=>{
        backgroundAviso.classList.remove("activo");
        aviso.classList.remove("activo");
    },300)

})
