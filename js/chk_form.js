
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

function chk_winForm(theForm){
    msg = '';
    if (chk_invoice15(theForm.special1_num.value)==false){
        msg = msg + '『特別獎』格式錯誤!! \n';
    }
    if (chk_invoice15(theForm.special2_num.value)==false){
        msg = msg + '『特獎』格式錯誤!! \n';
    }
    if (chk_invoice15(theForm.head1_num.value)==false || chk_invoice15(theForm.head2_num.value)==false || chk_invoice15(theForm.head3_num.value)==false){
        msg = msg + '『頭獎』格式錯誤!! \n';
    }
    if (chk_invoice6(theForm.winadd6_num1.value)==false || chk_invoice6(theForm.winadd6_num2.value)==false || chk_invoice6(theForm.winadd6_num3.value)==false || chk_invoice6(theForm.winadd6_num4.value)==false || chk_invoice6(theForm.winadd6_num5.value)==false){
        msg = msg + '『增開六獎』格式錯誤!! \n';
    }
    if (msg != ''){
        alert("資料有誤\n "+ msg );
        return false;	
    }else{
        return true;
    }   
}
function chk_invoice15(tt){
    if(tt.replace(/^\s+/g,"")==""){
        return false;
    }else if(/\d{8}/g.test(tt)==false || tt == '00000000') {
        return false;
    }
    return true;
}
function chk_invoice6(tt){
    if(tt.replace(/^\s+/g,"")==""){
        return true;
    }else if(/\d{3}/g.test(tt)==false || tt == '000') {
        return false;
    }
    return true;
}
function chk_firstid(tt){
    if(tt.replace(/^\s+/g,"")==""){
        return true;
    }else if(/^[A-Z]+$/.test(tt)==false || tt.length != 2) {
        return false;
    }
    return true;
}

function chk_myinvoice(theForm){
    msg = '';
    if (chk_firstid(theForm.first_id.value)==false || chk_invoice15(theForm.last_num.value)==false){
        msg = msg + '『號碼』格式錯誤!! \n';
    }
    if (theForm.invoice_price.value == ''){
        msg = msg + '『金額』請填寫！ \n';
    }else{
        if (isNaN(parseInt(theForm.invoice_price.value))){
            msg = msg + '『金額』請填入數字！ \n';
        }
    }
    if (theForm.invoice_date.value == ''){
        msg = msg + '『日期』請填寫！ \n';
    }else{
        if (isExistDate(theForm.invoice_date.value)==false){
            msg = msg + '『日期』格式錯誤！ \n';
        }
    }

    if (msg != ''){
        alert("資料有誤\n "+ msg );
        return false;	
    }else{
        return true;
    }   
}

function isExistDate(dateStr) { // yyyy-mm-dd
    var dateObj = dateStr.split('-');
  
    //列出12個月，每月最大日期限制
    var limitInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  
    var theYear = parseInt(dateObj[0]);
    var theMonth = parseInt(dateObj[1]);
    var theDay = parseInt(dateObj[2]);
    var isLeap = new Date(theYear, 1, 29).getDate() === 29; // 是否為閏年?
  
    if(isLeap) { // 若為閏年，最大日期限制改為 29
      limitInMonth[1] = 29;
    }
  
    // 比對該日是否超過每個月份最大日期限制
    return theDay <= limitInMonth[theMonth - 1]
  }
