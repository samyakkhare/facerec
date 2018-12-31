#facerec

FaceRec Register/Login 

Please follow the instructions to run the service on your machine:

Pre-requisites:

1.Install OpenCV (v3.3.0) and Python (v3.5.2)
	https://opencv.org/releases.html
	https://github.com/opencv/opencv_contrib/releases
2.Linux, Apache, mysql, PHP (v7.2.13) (LAMP stack)

Before running the website make sure:

1.Place the facerec folder in the /var/www/html directory.

2.Give permissions 777 or 775 (i.e executable permission to the following files and folders) :-
	Directories:
	1. input
	2. output
	3. trainer 
	4. tryrecog
	Files:
	1. haarcascade_frontalface_default.xml
	2. haarcascade_eye.xml
	3. upload_data.php
	4. upload_reg.php
	5. train.php
	6. test.py
	7. trainer.py
	8. recog.py

3. Import facerec.sql in your mysql

4. Edit get_conn() function in functions.php (Set the following according to your mysql and apache installation)
		$host = 'localhost';
		$user = 'root';
		$password = 'root';

5. Change the path of your python executable:
	1. in runner.php 
	 	from $command="/home/samyak/.virtualenvs/cv/bin/python test.py ".$_SESSION['eid'];
	    to $command="/path/to/python/executable test.py ".$_SESSION['eid'];
	2. in upload_data.php 
		from $command="/home/samyak/.virtualenvs/cv/bin/python recog.py ".$eid;
	    to $command="/path/to/python/executable recog.py ".$eid;
	3. in train.php
		from $command1="/home/samyak/.virtualenvs/cv/bin/python trainer.py ".$_SESSION['eid'];
		to $command1="/path/to/python/executable train.py ".$_SESSION['eid'];

6. Change the shebangs (1st line) 
from #!/home/samyak/.virtualenvs/cv/bin/python 
to #!/path/to/python/executable in the following files:
	1. test.py
	2. trainer.py
	3. recog.py

Finally.....
Running the portal: 
1. Go to your browser (tested on Firefox)
2. Enter localhost/facerec/ in the url browser or whatever path you are running the server

[Allow Camera access in the browser if prompted]

1. To register a user
	1. Click on Create your account
				or
	   Goto localhost/facerec/register
	2. Enter your credentials and click on Submit
	3. Click on Snap photo (atleast 10 times to upload 10 pictures)
		and then press Submit to register the face.
	4. Press logout.


2. After registering a user (to login)
	1. Enter your credentials
	2. Click on Snap Photo button and then press Submit
(Make sure you press Snap Photo before pressing Login)

P.s The index page redirects to test.html

- Developed and coded by
Samyak Khare
samyakkhare@gmail.com
https://github.com/samyakkhare/facerec/

