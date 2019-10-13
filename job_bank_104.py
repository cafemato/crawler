#!/usr/bin/python
# coding=UTF-8
# ver 3.0(加入function，抓取內頁，輸入資料庫的資料做預處理以便後續的Chart.JS)
##目標網址:104人力銀行，搜尋關鍵字[大數據]
##利用xpath取得資料後,以sqlalchemy與pandas連結mysql送入資料

import os
import sys
import json
#Part 1.輸入框輸入要搜尋的關鍵字keyword之後，會自動去搜尋職缺並存入資料庫
   
keyword = sys.argv[1]
t_name =  sys.argv[2]

# keyword = "大數據"
# t_name = "bigdata"
print (keyword)
print (t_name)

import requests
from lxml import etree
from fake_useragent import UserAgent
import pandas
from sqlalchemy import create_engine
import mysql.connector
from bs4 import BeautifulSoup
import time
import random
import pymysql
 
# 爬蟲主程式，輸入搜尋關鍵字keyword以及指定table名稱t_name兩參數後，開始爬蟲
def crawler(keyword,t_name):   
    ua = UserAgent()
    j = 1
    job_list = []
    while j<3:    
        headers = {'user-agent':ua.random}
        url = keyword_url(keyword)
        final_url = url + str(j)
    #   列印抓取的頁數
        print(final_url)
        res = requests.get(final_url, headers = headers)
        soup = BeautifulSoup(res.text, "html.parser")
        #所有職缺的總區塊
        data = soup.find_all("article", class_="b-block--top-bord job-list-item b-clearfix js-job-item")     
        if len(data) == 0:     #   如果抓不到資料就停止
            break
        for i in range(len(data)):
            try:
                position = data[i].find("a").text.strip()            
                company = data[i].find("ul").find("a").text.strip()
                area = data[i].find("ul",class_="b-list-inline b-clearfix job-list-intro b-content").find_all("li")[0].text.strip()
                industry = data[i].attrs['data-indcat-desc'].strip()     
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
                requirement = data[i].find("ul",class_="b-list-inline b-clearfix job-list-intro b-content").find_all("li")[1].text.strip()
                if requirement == "經歷不拘": 
                    requirement = 'N'
                else:
                    requirement = requirement.split("年以上")[0]
                education = data[i].find("ul",class_="b-list-inline b-clearfix job-list-intro b-content").find_all("li")[2].text.strip()
                content = data[i].find("p",class_="job-list-item__info b-clearfix b-content").text.strip()
                salary_low = data[i].find("div",class_="job-list-tag b-content").find("span").text.strip()
                if salary_low  == "待遇面議": 
                    salary_low = 'N/A'
                    salary_high = ''
                elif "元以上" in salary_low:
                    salary_low = ''.join(x for x in salary_low if x.isdigit())
                    salary_high = ''
                elif "~" in salary_low :
                    low = salary_low.split("~")[0]
                    high = salary_low.split("~")[1]
                    salary_low = ''.join(x for x in low if x.isdigit())
                    salary_high = ''.join(x for x in high if x.isdigit())                  
                updated = data[i].find("h2",class_="b-tit").find("span").text.strip()
                applicant = data[i].find("div",class_="b-block__right b-pos-relative").find("a").text.strip()
                if  "~" in applicant: 
                    tmp = applicant.split("~")[1]
                    applicant = ''.join(x for x in tmp if x.isdigit())
                else:
                    applicant = 'N/A'
                link =  data[i].find("h2").find("a").attrs['href'].strip()
                job_url = "https:" + link
                res2 = requests.get(job_url, headers = headers)
                soup = BeautifulSoup(res2.text, "html.parser")
                detail = soup.find("div", id="job")
                job_type = detail.find_all("div",class_="content")[0].find_all("dd")[2].text.strip()
                b_trip = detail.find_all("div",class_="content")[0].find_all("dd")[5].text.strip()
                if b_trip == "無需出差外派":
                    b_trip = 'N'
                else:
                     b_trip = 'Y'
                manager = detail.find_all("div",class_="content")[0].find_all("dd")[4].text.strip()
                if manager == "不需負擔管理責任":
                    manager = 'N'
                else:
                     manager = 'Y'
                language = detail.find_all("div",class_="content")[1].find_all("dd")[4].text.strip()
                if language == "不拘":
                    language = "N"
                else:
                    language = language.split("--")[0].strip()
                soft_skill = detail.find_all("div",class_="content")[1].find_all("dd")[5].text.strip()
                other_skill = detail.find_all("div",class_="content")[1].find_all("dd")[6].text.strip()                        
                job_list.append({"bank_id":"104","company":company,"position":position,"area":area,"salary_low":salary_low, "salary_high":salary_high, "industry":industry,
                                    "requirement":requirement,"education":education,"content":content,"applicant":applicant,"updated":updated,
                                 "link":job_url,"job_type":job_type, "b_trip":b_trip, "manager":manager, "language":language, "soft_skill":soft_skill,
                                 "other_skill":other_skill }) 
            except:
                continue                        
        j +=1
#     隨機休眠5~15秒後再執行下一頁的抓取
#     time.sleep(random.randrange(3,10))
    return job_list

#將關鍵字併入搜尋url
def keyword_url(keyword):
    url = "https://www.104.com.tw/jobs/search/?ro=0&keyword=" + keyword + "&order=1&asc=0&page="    
    return url 
# print(keyword_url("大數據"))

#輸入table名稱t_name後建立關鍵字對應的table
def check_table_exist(t_name):
    conn = pymysql.connect(host = "127.0.0.1", user = "root", passwd = "root" , db = "job_bank")
    #查詢前，必須先獲取游標
    cursor = conn.cursor()
    #先確認資料庫內有無此table
    stmt = "SHOW TABLES LIKE \'" +  t_name + "\'"
    cursor.execute(stmt)
    result = cursor.fetchone()
    if result:
        return True
    else:
        return False
  
def create_table(t_name, new=1):
    conn = pymysql.connect(host = "127.0.0.1", user = "root", passwd = "root" , db = "job_bank")
    #查詢前，必須先獲取游標
    cursor = conn.cursor()
    
    table_start = ''' CREATE TABLE IF NOT EXISTS '''
    table_end = '''(\
   `id` int(10) AUTO_INCREMENT NOT NULL,\
   `bank_id` VARCHAR(255) NULL,\
   `link`  VARCHAR(255) NULL,\
   `company` VARCHAR(255) NOT NULL,\
   `position` VARCHAR(255) NOT NULL,\
   `area` VARCHAR(255)  NULL,\
   `salary_low` VARCHAR(255) NULL,\
   `salary_high` VARCHAR(255) NULL,\
   `industry` VARCHAR(255) NULL,\
   `content` VARCHAR(255)  NULL,\
   `requirement` VARCHAR(255) NULL,\
   `education` VARCHAR(255) NULL,\
   `applicant` VARCHAR(255) NULL,\
   `updated` VARCHAR(255) NULL,\
   `job_type`  VARCHAR(255) NULL,\
   `b_trip`  VARCHAR(255) NULL,\
   `manager`  VARCHAR(255) NULL,\
   `language`  VARCHAR(255) NULL,\
   `soft_skill`  VARCHAR(255) NULL,\
   `other_skill`  VARCHAR(255) NULL,\
    KEY (`id`),\
    CONSTRAINT job_id PRIMARY KEY (`company`,`position`)\
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; \
    '''
    
    flag = check_table_exist(t_name)
    if flag and new == 1:        #Table t_name已存在，建立新命名的table
        t_name = "new_"+ t_name
        table = table_start + t_name + table_end
        cursor.execute(table)
        conn.commit()  
        cursor.close()      
        conn.close()       
    elif flag and new == 0:      #Table t_name已存在，不建立table
        print("Table已存在!不建立新Table!")
        cursor.close()      
        conn.close()       
    else:                        #Table t_name不存在，直接建立table        
        table = table_start + t_name + table_end
        cursor.execute(table)
        conn.commit()  
        cursor.close()     #關閉 cursor 物件 
        conn.close()       #關閉 conn 物件

def toDatabase(job_list,t_name):
    engine = create_engine('mysql+mysqlconnector://root:root@127.0.0.1:3306/job_bank?charset=utf8', encoding='utf-8')
    con = engine.connect() #建立連結

    for item in job_list:
        df = pandas.DataFrame(item, index=[0]) # 為何加入index[0]:因為單次僅一個dict轉成df,詳情:https://reurl.cc/4gm4qD
        try:
            df.to_sql(t_name,con=con,if_exists='append', index=False) #假設table已存在 就自動往下加入data
        except Exception as e:
            if 'PRIMARY' in str(e):
                pass
    con.close() #關閉資料池連結
    engine.dispose() #關閉資料庫連結

#呼叫爬蟲程式以及給予搜尋關鍵字和table名稱
job_list = crawler(keyword,t_name)

print("網頁已擷取完畢...")          
# XXX=table名稱
# 當table名稱已存在時，new=1 -> 建立table new_XXX
# 當table名稱已存在時，new=0 -> 不建立直接pass
# 當table名稱不存在時，無論new=0 or 1 -> 直接建立table XXX
create_table(t_name, new=0)

#連結資料庫
toDatabase(job_list,t_name)    
print("資料已存入資料庫...")    

# for i in sys.argv:
#     print('輸入參數為'+ json.dumps(i , ensure_ascii=False, indent=2))


#瀏覽器參數
from selenium import webdriver
from selenium.webdriver.chrome.options import Options 
CHROMEDRIVER_PATH = "/Users/ffmatojp/chromedriver"
driver = webdriver.Chrome(CHROMEDRIVER_PATH)
time.sleep(random.randrange(10,20)) 
driver.set_page_load_timeout(5) 
driver.get("http://localhost/chart.html")

print("工作已完成，請查看網頁之分析圖!")   
