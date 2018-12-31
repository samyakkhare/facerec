#!/home/samyak/.virtualenvs/cv/bin/python
import cv2 ,os
import numpy as np
from PIL import Image
import pickle
import sys

param1 = sys.argv[1]

recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('trainer/'+param1+'.yml')
cascadePath = "haarcascade_frontalface_default.xml"
faceCascade = cv2.CascadeClassifier(cascadePath);


# cam = cv2.VideoCapture(0)
fontface = cv2.FONT_HERSHEY_SIMPLEX
fontscale = 1
fontcolor = (255, 255, 255)
rec = 0
# while True:
im =cv2.imread('/var/www/html/facerec/tryrecog/'+param1+'.png')
gray=cv2.cvtColor(im,cv2.COLOR_BGR2GRAY)
faces=faceCascade.detectMultiScale(gray, 1.01,3)
for(x,y,w,h) in faces:
    cv2.rectangle(im,(x,y),(x+w,y+h),(225,0,0),2)
    Id, conf = recognizer.predict(gray[y:y+h,x:x+w])
    # print(Id)
    # print(conf)
    if(conf<50):
        rec=1
        # cv2.putText(im, str(Id), (x,y+h), fontface, fontscale, fontcolor) 
    # cv2.imshow('im',im) 
    # if cv2.waitKey(10) & 0xFF==ord('q'):
        # break
if(rec>0):
    print(1)
else:
    print(0)

# cam.release()
# cv2.destroyAllWindows()
