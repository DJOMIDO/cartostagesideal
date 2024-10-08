# -*- coding: utf-8 -*-
from bs4 import BeautifulSoup   # retourne un parse-tree 
                                # pour selectionne par xpath
from lxml import etree          # retourne un parse-tree pour 
                                # selectionne par xpath
import requests                 # envoyer request HTTP
import datetime                 # obtenir la date d'aujourd'hui
import os, stat                 # changer le mod des fichiers
import chardet                  # obtenir la valeur de encoding
import sys                      # changer l'encodage du stdout
import re                       # selectionner par regex
import io   



'''
Obtention du dossier des fichiers textes
'''
roadPare = "/home/IdL/2021/maxiao/public_html/cartostagesideal"        	# obtenir le chemin du dossier
pathFile = roadPare+"/text_files"                       				# definir le chemin des dossier .txt
if not os.path.exists(pathFile):                       					# Si le dossier n'existe pas encore, creer un
     os.makedirs(pathFile, 0o777)
pathWindow = roadPare+"/fichier_html"                   				# définir le chemin des dossier .html
if not os.path.exists(pathWindow):
    os.makedirs(pathWindow, 0o777)
os.chmod(pathFile,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
os.chmod(pathWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)   
print("it really works")


'''
Liste de Toulouse
'''                  
sys.stdout = io.TextIOWrapper(buffer=sys.stdout.buffer,encoding='utf8')
url = "http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html#Stages"
days = 20

def get_posts(url):
    '''
    Retourner les urls des stages dans le site
    Parameters:
        url (str): url du site de stages
    Returns:
        real_urls (list str): une liste de urls des stages
    '''
    posts = requests.get(url)
    posts.encoding = "utf-8"

    regex = 'href="(.*)"'
    all_urls = re.findall(regex, posts.text)
    real_urls = []
    for u in all_urls:
        if "offres/S" in u:
            real_urls.append(u)

    real_urls = real_urls[:days]
    return real_urls

def get_content(real_urls, url):
    '''
    Parcourir les informations des stages, et ecrire dans fichiers .txt et .html
    dans le serveur
    Parameters:
        url (str): url du site de stages
        real_urls (list str): une liste de urls des stages
    Returns:
        None
    '''
    half_url = "http://w3.erss.univ-tlse2.fr/membre/tanguy/"
    if(real_urls == []):
        print("no urls\n")
    else:
        posts = requests.get(url)
        posts.encoding = "utf-8"
        selector = etree.HTML(posts.text)

        dates = []
        institutes = []
        places = []
        titles = []
        for i in range(2,days+2):
            dateOrigin = selector.xpath("//tr[" + str(i) + "]/td[1]/text()")[2] # dates
            list_date = dateOrigin.split("/")
            date = list_date[2] + "-" + list_date[1] + "-" + list_date[0] # format y-m-d
            institute = selector.xpath("//tr[" + str(i) + "]/td[2]/text()")[2] # labos or firms
            place = selector.xpath("//tr[" + str(i) + "]/td[3]/text()")[2] # places
            title = selector.xpath("//tr[" + str(i) + "]/td[4]/a/text()")[2] # titles?

            dates.append(date)
            institutes.append(institute)
            places.append(place)
            titles.append(title)

        for i in range(len(real_urls)):

            c_post = requests.get(half_url + real_urls[i])
            # traiter encodage :
            encod = chardet.detect(c_post.content)['encoding'] # important, obtenir la valeur de encoding de detection
            if encod == "utf-8":
                c_post.encoding = encod
            else : 
                c_post.encoding = "windows-1252"
            c_corri = c_post.text
            # supprimer \n inapproprié :
            # (?<!(>|\n|\.|[A-Z]|[0-9]))\n(?!(<|\s|•|[1-9]\.|— |– |- |[A-Z]))
            regex = r"(?<!(>|\n|\.|[A-Z]|[0-9]))\n(?!(<|\s|•|[1-9]\.|— |– |- |[A-Z]))"
            c_corri_final = re.sub(regex," ",c_corri)

            filename = pathFile+"/Stage" + str(i) + ".txt"
            fileWindow = pathWindow+"/Stage" + str(i) + ".html"

            with open(filename, "w", encoding = "UTF-8") as fd:
                os.chmod(filename,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
                fd.write("Titre: " + titles[i] + "\n")
                fd.write("Date: " + dates[i] + "\n")
                fd.write("Organisme: " + institutes[i] + "\n")
                fd.write("Lieu: " + places[i] + "\n\n\n")
                fd.write(c_corri_final)
            with open(fileWindow, "w", encoding = "UTF-8") as fd:
                os.chmod(fileWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
                fd.write("""<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title> CartoStages </title></head><body>""")
                fd.write("<p>Titre: " + titles[i] + "</p>")
                fd.write("<p>Date: " + dates[i] + "</p>")
                fd.write("<p>Organisme: " + institutes[i] + "</p>")
                fd.write("<p>Lieu: " + places[i] + "</p><br/>")
                fd.write("<p>")
                for cara in c_corri_final: 
                    if cara != "\n":
                        fd.write(cara)
                    else :
                        fd.write("</p><p>")
                fd.write("</p>")
                fd.write("""</body></html>""")
                
real_urls = get_posts(url)
get_content(real_urls, url)


'''
LinkedIn
'''
url_lin = "https://www.linkedin.com/jobs/search?keywords=Nlp&location=France&locationId=&geoId=105015875&f_TPR=&f_JT=I"

def get_posts_linkedin(url_lin):
    '''
    Parcourir les informations des stages, et ecrire dans fichiers .txt et .html
    dans le serveur
    Parameters:
        url_lin (str): url du site de linked_in
    Returns:
        None
    '''
    posts = requests.get(url_lin)
    posts.encoding = "utf-8"

    selector = etree.HTML(posts.text)
    titles = selector.xpath('//*[@class="base-search-card__title"]/text()')
    locations = selector.xpath('//*[@class="job-search-card__location"]/text()')
    companies = selector.xpath('//*[@class="hidden-nested-link"]/text()')

    regex = 'href="(.*)" data-tracking-control-name="public_jobs_jserp-result_search-card"'
    all_urls = re.findall(regex, posts.text)
    regex = 'datetime="(.*)">'
    dates = re.findall(regex, posts.text)
    
    for i in range(3):
        #sftp://liuqinyu@i3l.univ-grenoble-alpes.fr/home/IdL/2021/liuqinyu/public_html/new/fichier_html
        filename = pathFile+"/Linkedin" + str(i) + ".txt"
        fileWindow = pathWindow+"/Linkedin" + str(i) + ".html"

        title = titles[i].strip(" \n")
        location = locations[i].strip(" \n")
        company = companies[i].strip(" \n")
        list_date = dates[i].split("-")
        # format d/m/y ------ date = list_date[2] + "/" + list_date[1] + "/" + list_date[0]
        # format y-m-d :
        date = list_date[0] + "-" + list_date[1] + "-" + list_date[2]

        # print(titles[i])
        with open(filename,'w',encoding="UTF-8") as fd:
            os.chmod(filename,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
            fd.write("Titre: " + title + "\n")
            fd.write("Date: " + date + "\n")
            fd.write("Organisme: " + company + "\n")
            fd.write("Lieu: " + location + "\n\n\n")
            fd.write(all_urls[i] + "\n")
        with open(fileWindow,'w',encoding="Windows-1252") as fd:
            os.chmod(fileWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
            fd.write("""<!DOCTYPE html><html lang="fr"><head><meta charset="Windows-1252"><title>CartoStages</title></head><body>""")
            fd.write("<p>Titre: " + title + "</p>")
            fd.write("<p>Date: " + date + "</p>")
            fd.write("<p>Organisme: " + company + "</p>")
            fd.write("<p>Lieu: " + location + "</p><br/>")
            fd.write("<p>"+all_urls[i] + "</p>")
            fd.write("""</body></html>""")

get_posts_linkedin(url_lin)

 

'''
Indeed
'''
urlIndeed = "https://fr.indeed.com/emplois?q=traitement+automatique+des+langues&jt=internship"

# obtenir les codes html de la page Indeed
server = "https://fr.indeed.com"
target = urlIndeed
req = requests.get(url = target)
html = req.text

# obtenir les urls des pages de stages
urls = []
divJobcard = BeautifulSoup(html,'lxml')
jobcard = divJobcard.find('div', id = 'mosaic-provider-jobcards')
divA = BeautifulSoup(str(jobcard),'lxml')
# a = divA.find_all('a', rel="nofollow",target="_blank")
a = divA.find_all('a', class_="jcs-JobTitle" , target="_blank")
for hrefStage in a :
    href = server + hrefStage.get('href')
    urls.append(href)


def getUrl(urlhtml):
    '''
    Obtenir le code source en html du site
    Parameters:
        urlhtml (str): url du site de stages
    Returns:
        html (any): code source du site
    '''
    response = requests.get(url=urlhtml)
    wb_data = response.text
    html = etree.HTML(wb_data) 
    return html

def getTitle(urlStage) : 
    '''
    Obtenir le titre de stage
    Parameters:
        urlStage (str): url du site de stages
    Returns:
        title[0] (str): le titre
    '''
    htmlStage = getUrl(urlStage)
    title = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[1]/h1/text()')
    #                        //*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[1]/h1
    #                        //*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[1]/h1
    if len(title) == 0 : 
        title = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[1]/h1/text()')
    return title[0] # avoir une liste avec un seul titre, pour obtenir le titre seulement, utiliser indice = 0

def getInst(urlStage):
    '''
    Obtenir l'institut de stage
    Parameters:
        urlStage (str): url du site de stages
    Returns:
        institue[0] (str): l'institue
    '''
    htmlStage = getUrl(urlStage)
    institue = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[2]/div/div/div/div[1]/div[2]/div//text()')
    if len(institue) == 0 : 
        institue = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[2]/div/div/div/div[1]/div[2]/div//text()')
    #                           //*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[2]/div/div/div/div[1]/div[2]/div/a
    return institue[0]

def getPlace(urlStage):
    '''
    Obtenir le lieu de stage
    Parameters:
        urlStage (str): url du site de stages
    Returns:
        place[0] (str): le lieu
    '''
    htmlStage = getUrl(urlStage)
    place = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[2]/div/div/div/div[2]/div/text()')
    if len(place) == 0 :
        place = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[2]/div/div/div/div[2]/div/text()')
    return place[0]

def getDate(urlStage):
    '''
    Obtenir la date de stage
    Parameters:
        urlStage (str): url du site de stages
    Returns:
        Date (str): la date
    '''
    htmlStage = getUrl(urlStage)
    dateChaine = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[6]/div[2]//text()')
    if len(dateChaine) == 0 :
        dateChaine = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[7]/div[2]//text()')
    for chaine in dateChaine :
        if "il y a" in chaine :
            entre = str(chaine)
            numDate = int(entre[7:9])
            today = datetime.date.today()
            Date = today - datetime.timedelta(days=numDate)
            Date = Date.strftime("%Y-%m-%d")
            return Date
        if "instant" in chaine or "Aujourd'hui" in chaine :
            Date = datetime.date.today()
            Date = Date.strftime("%Y-%m-%d")
            return Date

def getContent(urlStage):
    '''
    Parcourir les informations des stages, et ecrire dans fichiers .txt et .html
    dans le serveur
    Parameters:
        urlStage (str): url du site de stages
    Returns:
        None
    '''
    htmlStage = getUrl(urlStage)
    head = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]//text()')
    body = htmlStage.xpath('//*[@id="jobDescriptionText"]//text()')
    content = head + body
    return content # obtenir une liste des chaînes

# pour chaque site du stage, obtenir les informations et les écrire dans un fichier .txt

for href in urls : 
    # obtenir les informations
    # pour test : print(str(href))
    title = getTitle(href)
    date = getDate(href)
    inst = getInst(href)
    place = getPlace(href)
    content = getContent(href) # une liste mais pas str
    # et les écrire dans un fichier .txt
    i = urls.index(href)

    filename = pathFile+"/Indeed" + str(i) + ".txt"
    txt = open(filename, "w+", encoding = "UTF-8")
    os.chmod(filename,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
    txt.write("Titre: " + title + "\n")
    txt.write("Date: " + date + "\n")
    txt.write("Organisme: " + inst + "\n")
    txt.write("Lieu: " + place + "\n")
    txt.write("\n\n")
    for line in content : # écrire ligne par ligne
        txt.write(line)
    txt.close()
    
    fileWindow = pathWindow+"/Indeed" + str(i) + ".html"
    html = open(fileWindow, "w+", encoding = "UTF-8")
    os.chmod(fileWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
    html.write("""<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>CartoStages</title></head><body>""")
    html.write("<p>Titre: " + title + "</p>")
    html.write("<p>Date: " + date + "</p>")
    html.write("<p>Organisme: " + inst + "</p>")
    html.write("<p>Lieu: " + place + "</p><br/>")
    for line in content : # écrire ligne par ligne
        html.write("<p>" + line + "</p>")
    html.write("""</body></html>""")
    html.close()
