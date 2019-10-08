# crawler
Web crawler for Job Bank 104 https://www.104.com.tw
(with lxml &amp; Beautifulsoup)

104人力銀行job_bank欄位定義
#資料庫名稱job_bank


1.公司名稱       company               //招募公司名稱
2.職缺名稱       position              //職缺的名稱抬頭
3.工作性質       job_type              //全職/兼差/工讀
4.工作地區       area [option]         //公司或是工作所在地區
5.最低起薪       salary_low 
5.最高起薪       salary_high 
7.產業類別       industry 
8.工作內容       content 
9.要求條件       requirement 
10.學歷要求       education
11.刊登/更新日期  updated  
12.語文條件      language                 
13.擅長工具      soft_skill
14.工作技能      other_skill
15.出差外派      b_trip
16.管理責任      manager


產業類別
1.金融業(金融/投資/證劵/保險)
2.資訊科技業(含電腦/軟體/硬體/網路/)
3.電子電信業(含半導體/電信/電子/光電)
3.一般商業(含管理/人力/行政/行銷/企劃/法務/專利/顧問/財務/會計/稽核/審計/國際貿易/業務/客服/門市)
4.傳產製造業(含食品/飲料/紡織/建築/家具家飾/製紙/印刷/化工/金屬/機械/電力/運輸/儀器/物流/倉儲/營建土木/農林漁牧/礦業土石/品管/品保)
5.文化媒體業(含出版/翻譯/影視/演藝/新聞.媒體/美編/裝潢/設計)
6.教育研究醫療生技業(教育/研究/醫/生技/生化)
7.服務業(美容/美髮/餐飲/烘焙/觀光/旅遊/服務)
8.其他產業(任何其他專業等)


    
if any(x in industry for x in ['金融','銀行業','保險','投資',"證券"]):
    industry = "金融業"
elif any(x in industry for x in ["電腦","軟體","硬體","系統","網路"]):
    industry = "資訊科技業"
elif any(x in industry for x in ["半導體","電信","電子","光電"]):
    industry = "電子電信業"
elif  any(x in industry for x in ["製造","食品","飲料","紡織","家具","製紙","印刷","化工","金屬","機械","電力","運輸","儀器","建築","物流","倉儲","營建","品管","品保","土木","農林漁牧","礦業土石"]):
    industry = "傳產製造業"
elif  any(x in industry for x in ["出版","翻譯","影視","演藝","新聞","媒體","美編","設計","裝潢","傳播"]):
    industry = "文化媒體業"
elif  any(x in industry for x in ["教育","研究","醫","生化","生技"]):
    industry = "教育研究醫療生技業"
elif  any(x in industry for x in ["經營","零售","管理","行政","行銷","企劃","顧問","財務","會計","稽核","審計","國際貿易","業務","客服"]):
    industry = "一般商業"
elif  any(x in industry for x in ["美容","美髮","餐飲","烘培","觀光","旅遊","門市"]):
    industry = "服務業"  
else:
    industry = "其他產業" 
