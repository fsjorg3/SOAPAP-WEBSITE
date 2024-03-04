let aviso = document.getElementById("aviso");
let btn =  document.getElementById("btn_aceptar");

    
aviso.classList.add("activo");

btn.addEventListener("click",()=>{

    aviso.classList.add("efecto");
    setTimeout(()=>{
        aviso.classList.remove("activo");
    },300)

})
