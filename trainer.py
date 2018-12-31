#!/home/samyak/.virtualenvs/cv/bin/python
import cv2,os
import numpy as np
from PIL import Image
import sys

param1 = sys.argv[1]
param2 = int(sys.argv[1])

recognizer = cv2.face.LBPHFaceRecognizer_create()
detector= cv2.CascadeClassifier("/var/www/html/lel/haarcascade_frontalface_default.xml");

def getImagesAndLabels(path):
    #get the path of all the files in the folder
    imagePaths=[]
    for f in os.listdir(path):
        g=f
        eid=int(os.path.split(f)[-1].split("_")[0])
        if eid==param2:
            imagePaths.append(os.path.join(path,g))
    #create empty face list
    faceSamples=[]
    #create empty ID list
    Ids=[]
    #now looping through all the image paths and loading the Ids and the images
    for imagePath in imagePaths:
        #loading the image and converting it to gray scale
        pilImage=Image.open(imagePath).convert('L')
        # print(pilImage)
        #Now we are converting the PIL image into numpy array
        imageNp=np.array(pilImage,'uint8')
        # print(imageNp)
        #getting the Id from the image
        Id=int(os.path.split(imagePath)[-1].split(".")[1])
        # print(Id)
        # extract the face from the training image sample
        faces=detector.detectMultiScale(imageNp)
        #If a face is there then append that in the list as well as Id of it
        for (x,y,w,h) in faces:
            faceSamples.append(imageNp[y:y+h,x:x+w])
            Ids.append(Id)
    return faceSamples,Ids


faces,Ids = getImagesAndLabels('/var/www/html/lel/output')
recognizer.train(faces, np.array(Ids))
recognizer.write('trainer/'+param1+'.yml')

print(1)
