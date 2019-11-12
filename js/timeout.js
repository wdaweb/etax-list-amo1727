
let sec_timeout = 1200;
let div_timeout = document.querySelector("#timeout em");
div_timeout.innerText = sec_timeout;
let timer_timeout = setInterval(() => {                               
    sec_timeout--;
    div_timeout.innerText = sec_timeout;
    if (sec_timeout == 0) {
        clearInterval(timer_timeout); 
        setTimeout(()=>{
            alert("頁面停滯過長，系統即將登出!!");
            location.href='index.php?logout=1';
        },10);    
    }
}, 1000);
