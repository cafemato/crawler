# coding=UTF-8
# ver 2.0(抓取內頁)
##目標網址:104人力銀行，搜尋關鍵字[大數據]
##利用xpath取得資料後,以sqlalchemy與pandas連結mysql送入資料
import requests
from lxml import etree
from fake_useragent import UserAgent
import pandas
from sqlalchemy import create_engine
import mysql.connector
from bs4 import BeautifulSoup
import time
import random

##偽裝瀏覽器及OS
ua = UserAgent()
##抓取資料Base url
##隨機變換瀏覽器及OS
j = 1
job_list = []
while j < 2:
    headers = {'user-agent':ua.random}
    url = "https://www.104.com.tw/jobs/search/?ro=0&keyword=大數據&order=1&asc=0&page="
    final_url = url + str(j)
#   列印抓取的頁數
    print(final_url)
    res = requests.get(final_url, headers = headers)
    soup = BeautifulSoup(res.text, "html.parser")
    data = soup.find_all("article", class_="b-block--top-bord job-list-item b-clearfix js-job-item")
#   如果抓不到資料就停止
    if len(data) == 0:
        break
    for i in range(len(data)):
        try:
            position = data[i].find("a").text.strip()
            company = data[i].find("ul").find("a").text.strip()
            area = data[i].find("ul",class_="b-list-inline b-clearfix job-list-intro b-content").find_all("li")[0].text.strip()
            industry = data[i].attrs['data-indcat-desc'].strip()
            requirement = data[i].find("ul",class_="b-list-inline b-clearfix job-list-intro b-content").find_all("li")[1].text.strip()
            education = data[i].find("ul",class_="b-list-inline b-clearfix job-list-intro b-content").find_all("li")[2].text.strip()
            content = data[i].find("p",class_="job-list-item__info b-clearfix b-content").text.strip()
            salary = data[i].find("div",class_="job-list-tag b-content").find("span").text.strip()
            updated = data[i].find("h2",class_="b-tit").find("span").text.strip()
            applicant = data[i].find("div",class_="b-block__right b-pos-relative").find("a").text.strip()
            link =  data[i].find("h2").find("a").attrs['href'].strip()
            job_url = "https:" + link
            res2 = requests.get(job_url, headers = headers)
            soup = BeautifulSoup(res2.text, "html.parser")
            detail = soup.find("div", id="job")
            job_type = detail.find_all("div",class_="content")[0].find_all("dd")[2].text.strip()
            b_trip = detail.find_all("div",class_="content")[0].find_all("dd")[5].text.strip()
            manager = detail.find_all("div",class_="content")[0].find_all("dd")[4].text.strip()
            language = detail.find_all("div",class_="content")[1].find_all("dd")[4].text.strip()
            soft_skill = detail.find_all("div",class_="content")[1].find_all("dd")[5].text.strip()
            other_skill = detail.find_all("div",class_="content")[1].find_all("dd")[6].text.strip()
            job_list.append({"bank_id":"104","company":company,"position":position,"area":area,"salary":salary, "industry":industry,
                                "requirement":requirement,"education":education,"content":content,"applicant":applicant,"updated":updated,
                             "link":job_url,"job_type":job_type, "b_trip":b_trip, "manager":manager, "language":language, "soft_skill":soft_skill,
                             "other_skill":other_skill })
        except:
#             education = ""
#             area = ""
            continue
    j +=1
#     隨機休眠5~15秒後再執行下一頁的抓取
#     time.sleep(random.randrange(3,10))

# 在mysql的db中 建立好table,PRIMARY KEY=company+position
# bigdata=table 名稱
'''
CREATE TABLE IF NOT EXISTS `bigdata`(
   `id` int(10) AUTO_INCREMENT NOT NULL,
   `bank_id` VARCHAR(255) NULL,
   `link`  VARCHAR(255) NULL,
   `company` VARCHAR(255) NOT NULL,
   `position` VARCHAR(255) NOT NULL,
   `area` VARCHAR(255)  NULL,
   `salary` VARCHAR(255) NULL,
   `industry` VARCHAR(255) NULL,
   `content` VARCHAR(255)  NULL,
   `requirement` VARCHAR(255) NULL,
   `education` VARCHAR(255) NULL,
   `applicant` VARCHAR(255) NULL,
   `updated` VARCHAR(255) NULL,
   `job_type`  VARCHAR(255) NULL,
   `b_trip`  VARCHAR(255) NULL,
   `manager`  VARCHAR(255) NULL,
   `language`  VARCHAR(255) NULL,
   `soft_skill`  VARCHAR(255) NULL,
   `other_skill`  VARCHAR(255) NULL,
    KEY (`id`),
    CONSTRAINT job_id PRIMARY KEY (`company`,`position`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
'''

#連結資料庫
#範本解釋:create_engine('mysql+mysql_driver://mysql帳號:mysql密碼@機器ip:mysql_port/DB名稱?其他參數', encoding='mysql編碼'
#charset=utf8 資料庫編碼
engine = create_engine('mysql+mysqlconnector://root:root@127.0.0.1:3306/job_bank?charset=utf8', encoding='utf-8')
con = engine.connect() #建立連結

for item in job_list:
    df = pandas.DataFrame(item, index=[0]) # 為何加入index[0]:因為單次僅一個dict轉成df,詳情:https://reurl.cc/4gm4qD
    try:
        df.to_sql("bigdata",con=con,if_exists='append', index=False) #假設table已存在 就自動往下加入data
    except Exception as e:
        if 'PRIMARY' in str(e):
            pass
con.close() #關閉資料池連結
engine.dispose() #關閉資料庫連結
