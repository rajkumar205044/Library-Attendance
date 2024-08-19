import mysql.connector
import numpy as np
from PIL import Image
import pyautogui as do
import winsound 
import cv2
import io
import time
import threading
import sys
from deepface import DeepFace

for window in do.getAllWindows():
    if "Library Attendance" == window.title:
        sys.exit()
cnx = mysql.connector.connect(
    host="localhost",
    user="root",
    password="hello",
    database="library"
)
images=[]
regnos=[]
names=[]
block=[]
cursor = cnx.cursor()
query = "SELECT * FROM students"
cursor.execute(query)
results = cursor.fetchall()
for row in results:
    if row[3]:
        images .append( np.array(Image.open(io.BytesIO(row[3]))))
        regnos.append(row[0])
        names.append(row[1])
cursor.close()
def block_this(regno):
    block.append(regno)
    time.sleep(60)
    block.remove(regno)
def attendance(regno):
    if regno not in block:
        query = "SELECT * FROM logs where date=CURRENT_DATE() AND regno='"+str(regno)+"' AND outtime IS NULL"
        try:
            cursor=cnx.cursor()
            cursor.execute(query)
        except mysql.connector.Error as err:
            print(err)
        except Exception as e:
            print(e)
        results=cursor.fetchall()
        if len(results)==0:
            query="INSERT INTO logs(date,regno,intime) values(CURRENT_DATE(),'"+str(regno)+"',CURRENT_TIME())"
            cursor.execute(query)
            cnx.commit()
            thread = threading.Thread(target=block_this,args=(regno,))
            thread.start()
            print("INtime done")
            winsound.Beep(1000,500)
            winsound.Beep(1000,500)
            return True        
        else:
            query = "UPDATE logs SET outtime=CURRENT_TIME() where date=CURRENT_DATE() AND regno='"+str(regno)+"' AND outtime IS NULL"
            cursor.execute(query)
            cnx.commit()
            thread = threading.Thread(target=block_this,args=(regno,))
            thread.start()
            print("outtime done")
            winsound.Beep(1000,1000)
            return False
        cursor.close()
def find_face(frame):
    i=0
    print(f"face found")
    winsound.Beep(2000,500)
    for image in images:
        image1_path = image
        image2_path = frame
        try:
            result = DeepFace.verify(image1_path, image2_path)
            if result["verified"]:
                #print(names[i])
                att_val=attendance(regnos[i])
                if att_val is not None:
                    if att_val:
                        return str(regnos[i])+"-"+names[i],(255,0,0)
                    else:
                        return str(regnos[i])+"-"+names[i],(0,255,0)
        except:
            pass
        i+=1
    winsound.Beep(2000,250)
    winsound.Beep(2000,250)

##            cv2.rectangle(frame, (x, y), (x+w, y+h), (255, 0, 0), 2)
##            face_data=find_face(frame)
##            if face_data is not None:
##                name,color=face_data
##            else:
##                name,color="",(255,255,0)
##            cv2.putText(frame, name, (x, y+h+20), cv2.FONT_HERSHEY_SIMPLEX, 0.5, color, 2, cv2.LINE_AA)
def main():
    cap = cv2.VideoCapture(1)
    if not cap.isOpened():
        cap = cv2.VideoCapture(0)
    if not cap.isOpened():
        print("Error: Failed to connect camera")
        return
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')    
    while True:
        _,frame = cap.read()
        faces = face_cascade.detectMultiScale(cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY), scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
        if len(faces)>0:
            time.sleep(1)
            _,frame = cap.read()
            faces = face_cascade.detectMultiScale(cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY), scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
            if len(faces)>0:
                find_face(frame)
        cv2.imshow('Library Attendance', frame)
        time.sleep(0.3)
    cap.release()
    cv2.destroyAllWindows()

if __name__ == "__main__":
    winsound.Beep(500,5000)
    winsound.Beep(1000,500)
    main()
