# Webcrawler to Visualization(Automatic)

Language
-Python integrated with PHP

DB
-MySQL

Crawler
-Web crawler for major job bank website 104 https://www.104.com.tw in Taiwan  
(with Lxml and Beautifulsoup)       
![alt text](https://github.com/cafemato/crawler-storage-visualization/console.png)

DB
-MySQL
![alt text](https://github.com/cafemato/crawler-storage-visualization/db.png)

Visualization
-PHP with jQuery, ChartJS

![alt text](https://github.com/cafemato/crawler-storage-visualization/visualization.png)

This crawler use crawler.php to call job_bank_104.py to run the crawler  
Crawler.php need to be running in Terminal(Command Line Interface)  
You need to input the keyword(Ex. Java Engineer or 人工智慧) you want to search and the database table name response to keyword
After crawler is done, it create table automatically in the database job_bank    
Job_bank_104.py will write sql command to datapool.php & call chart.html to open new page in Chrome Browser and visualizes the chart analysis(use Chart.JS) for the data collected in table.(Now there are four chart in chart.html)  

crawler.php : main execution file. Run: php crawler.php to execute  
job_bank_104.py : main crawler    
datapool.php: sql command for chart visualization auto produced by crawler.php    
chart.html: main chart file    

There is also a complete edition crawler for Taiwan's 4 main job banks:104、1111、518、Linkedin     
chart_team.html : main chart file to show visualized data for 4 job banks  
data.php : sql command for chart visualization for chart_team.html  
job_bank.sql : data collected by 4 crawler files(need to import to your mysql database)    


Before crawler.php execution, you need to:    
1.Install MAMP or XAMPP to have LAMP in your environment    
2.create job_bank database in your local mysql database(or use phpmyadmin)   
3.Install the following package in your Terminal(CLI) to run python program needed:  
4.Install chrome driver in your Terminal(CLI) to open the chart.html automatically
(ChromeDriver 76.0.3809.126 recommend)  

python3.6 -m pip install --upgrade pip  
python3.6 -m pip install requests  
python3.6 -m pip install lxml  
python3.6 -m pip install beautifulsoup4  
python3.6 -m pip install SQLAlchemy  
python3.6 -m pip install mysql-connector-python  
python3.6 -m pip install pandas  
python3.6 -m pip install fake-useragent  
python3.6 -m pip install pymysql  
(python3.6 can change to your current python version, over python 3 is needed)  

4.Run: php carwler.php in Terminal mode  
5.Done! Enjoy it!  
6.To run the chart visualization for 4 banks, just import job_bank.sql to mysql database & open chart_team.html    

104人力銀行job_bank欄位定義  
#Database_name job_bank  
#Schema definition for job_bank

1.公司名稱       company               //company name   
2.職缺名稱       position              //job title     
3.工作性質       job_type              //full/part-time    
4.工作地區       area                  //company location    
5.最低起薪       salary_low            //salary from  
6.最高起薪       salary_high           //salary to  
7.產業類別       industry              //industry job belongs to  
8.工作內容       content               //detail job description  
9.要求條件       requirement           //how many years experience  
10.學歷要求      education             //degree  
11.刊登/更新日期  updated               //date job posted  
12.語文條件      language              //language required  
13.擅長工具      soft_skill            //sofeware skill required  
14.工作技能      other_skill           //other skill required  
15.出差外派      b_trip                //need to business trip  
16.管理責任      manager               //manager level position   


#產業類別(Industry genre)  
1.金融業 Finnance (金融/投資/證劵/保險)  
2.資訊科技業 IT (含電腦/軟體/硬體/網路/)  
3.電子電信業 Electronic & Telecom (含半導體/電信/電子/光電)  
3.一般商業 General Business (含管理/人力/行政/行銷/企劃/法務/專利/顧問/財務/會計/稽核/審計/國際貿易/業務/客服/門市)  
4.傳產製造業 Manufacturing & Traditional industry(含食品/飲料/紡織/建築/家具家飾/製紙/印刷/化工/金屬/機械/電力/運輸/儀器/物流/倉儲/營建土木/農林漁牧/礦業土石/品管/品保)  
5.文化媒體業 Cluture & Media (含出版/翻譯/影視/演藝/新聞.媒體/美編/裝潢/設計)  
6.教育研究醫療生技業 Edu & Medical & Biotech(教育/研究/醫/生技/生化)  
7.服務業 Service (美容/美髮/餐飲/烘焙/觀光/旅遊/服務)  
8.其他產業 Others (任何其他專業等)  


#Visualization Charts  
chart.html:   
1.Histogram chart # of the jobs distribution in different industry  
2.Scatter chart for requirement & salary distribution  
3.Radar chart for salary distribution in different industry  
4.Area chart for # of the jobs distribution in different area  

chart_team.html  
1.Area chart for # of the jobs by keyword  
2.Scatter chart for requirement & salary distribution  
3.Radar chart for salary distribution in different industry  
4.Polar chart for # of the jobs distribution in different area  
