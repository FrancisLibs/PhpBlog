# phpBlog
Blog project. 

It's a project of a serie of 9 projects.
It's purpose is object-oriented programming a website.

The project is versioned by github: https://github.com/FrancisLibs/phpBlog.git

And Codacy : https://app.codacy.com/manual/FrancisLibs/phpBlog/dashboard

Project URL : http://www.projet4.francislibs.fr/

Installation :

- First you have to install an apache or other type of server.

- Install composer and use composer update to install the dependencies.

- With composer, you have to install swiftmailer.

- Clone or download project by github, in a file by your server path, like c:\wamp64\www\ if you are under window with WAMP.

- Install, with phpAdmin from Wamp, the database : 
	- Create a "phpblog" database. 
	- Use the import command to fill the database.
	- Use the select file command and choose from the downloaded package, the sql file located in dataBase folder and execute it.

- To use this local installation, you can leave the informations in the phpblog/conf.php file: 
	 	"db_user" =>  "root"
    		"db_pass" =>  ""
    		"db_host" =>  "localhost"
    		"db_name" =>  "phpblog

	The db_user parameter is the database acces id and db_pass is the password.
	If your database has other access name or/and password, change as you need.	

- For sending emails you must also modify parameters in the same conf file.

	

