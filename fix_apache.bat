sc config Apache2.4 binPath= " \C:\laragon\bin\apache\httpd-2.4.66-260223-Win64-VS18\bin\httpd.exe\ -k "runservice  
sc config Apache2.4 start= demand  
net start Apache2.4 
