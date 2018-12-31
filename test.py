#!/home/samyak/.virtualenvs/cv/bin/python
import numpy as np
import cv2
import os, os.path
import sys

param1 = sys.argv[1]
param2 = int(sys.argv[1])

minimum = 5
count = 0

#multiple cascades: https://github.com/Itseez/opencv/tree/master/data/haarcascades

#https://github.com/Itseez/opencv/blob/master/data/haarcascades/haarcascade_frontalface_default.xml
face_cascade = cv2.CascadeClassifier('/var/www/html/facerec/haarcascade_frontalface_default.xml')
#https://github.com/Itseez/opencv/blob/master/data/haarcascades/haarcascade_eye.xml
eye_cascade = cv2.CascadeClassifier('/var/www/html/facerec/haarcascade_eye.xml')

# DIR = '/var/www/html/lel/input'
# for f in os.listdir(DIR):
#     g=f
#     eid=int(os.path.split(f)[-1].split("_")[0])
#     if eid==param2:
#         tcount=tcount+1
# numPics = len([name for name in os.listdir(DIR) if os.path.isfile(os.path.join(DIR, name))])
# print(numPics)
numPics= 10
for pic in range(1, (numPics+1)):
    img = cv2.imread('/var/www/html/facerec/input/'+param1+'_'+str(pic)+'.png')
    # height = img.shape[0]
    # width = img.shape[1]
    # size = height * width
    # print("yo")
    # print(str(pic))

    # if size > (500^2):
    #     r = 500.0 / img.shape[1]
    #     dim = (500, int(img.shape[0] * r))
    #     img2 = cv2.resize(img, dim, interpolation = cv2.INTER_AREA)
    #     img = img2

    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_cascade.detectMultiScale(gray,scaleFactor=1.3,minNeighbors=3)
    eyesn = 0
    n = 1
    # print("yo1")
    # cv2.imshow('img',gray)
    # cv2.waitKey()
    # print(faces)
    for (x,y,w,h) in faces:
        # print("yo3")
        imgCrop = gray[y:y+h,x:x+w]
        #cv2.rectangle(img,(x,y),(x+w,y+h),(255,0,0),2)
        roi_gray = gray[y:y+h, x:x+w]
        roi_color = img[y:y+h, x:x+w]
        # print("yo4")
        eyes = eye_cascade.detectMultiScale(roi_gray)
        # print(eyes)
    # for (ex,ey,ew,eh) in eyes:
    #         # cv2.rectangle(roi_color,(ex,ey),(ex+ew,ey+eh),(0,255,0),2)
    #     print("yo5")
    #     eyesn = eyesn +1
    #     print(eyesn)
    # if eyesn >= 2:
        # print(eyesn)
        # print(n)
        # print("writing")
        cv2.imwrite("/var/www/html/facerec/output/"+param1+"_"+str(pic)+ "." + str(n)+".png",imgCrop)
        n=n+1
        count=count+1
    #cv2.imshow('img',imgCrop)
    # print("Image"+str(pic)+" has been processed and cropped")
    # k = cv2.waitKey(30) & 0xff
    # if k == 27:
    #     break

#cap.release()
tcount = 0
path='/var/www/html/facerec/output'
for f in os.listdir(path):
    g=f
    eid=int(os.path.split(f)[-1].split("_")[0])
    if eid==param2:
        tcount=tcount+1

if count>=5 or tcount>=5:
    print(1)
else:
    print(0)
