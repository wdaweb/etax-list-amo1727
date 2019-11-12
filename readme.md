# 作業-統一發票紀錄與對獎系統

## 網頁畫面
1. 使用者登入頁(index.php)
2. 登入後首頁-當期統一發票中獎號碼與中獎清單(main.php)
    * 可查其他期
3. 我的發票(myinvoice.php)
    * 發票列表
    * 新增
    * 修改
    * 刪除
4. 中獎號碼登錄(winnum.php)
    * 輸入各期中獎號碼
5. 發票資料產生器(invoice_autoproduce.php)
    * 輸入筆數與年份自動產生資料

## DB設計(dbinvoice)
1. 使用者資料(user_data)
    * pk
    * acc 帳號 
    * pw 密碼 
    * name 名稱 
    * enable 是否啟用 
    * superadm 是否最高權限 
2. 使用者發票(user_invoice)
    * pk
    * user_data_pk 使用者pk
    * first_id 二位英文字 
    * last_num 8位流水號數字是從00000001－99999999
    * invoice_price 發票金額
    * invoice_date 發票日期
    * credit_time 資料建立時間
    * modify_time 資料最後修改時間
3. 中獎號碼原始規則(winnum_original)
    * pk
    * winnum_year 中獎號碼西元年
    * winnum_stage 中獎號碼期別(1~6)
    * special1_num 特別獎號碼
    * special2_num 特獎號碼 
    * head1_num 頭獎號碼第1組
    * head2_num 頭獎號碼第2組
    * head3_num 頭獎號碼第3組    
    * modify_userpk 資料最後修改者pk
    * modify_time 資料最後修改時間
4. 中獎號碼增開六獎(winnum_add6)
    * pk
    * original_pk
    * winadd6_num 增開六獎號碼
    * modify_userpk 資料最後修改者pk
    * modify_time 資料最後修改時間


