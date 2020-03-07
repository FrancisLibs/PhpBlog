# phpBlog
Blog project. 

It is a project of a serie of 9 projects.
It's purpose is object-oriented programming a website.

The project is versioned by github: https://github.com/FrancisLibs/phpBlog.git

And Codacy : https://app.codacy.com/manual/FrancisLibs/phpBlog/dashboard

Project URL : http://www.projet4.francislibs.fr/

Installation :

- First you have to install an apache or other type of server.
- Install composer and use composer update to install the dependencies.

- Clone or download project by github, in a file by your server path, like c:\wamp64\www\, if you are under window with WAMP.

- Install, with phpAdmin from Wamp, the database : 
	- Create a "phpblog" database. 
	- Use the import command to fill the database.
	- Use the select file command and choose from the downloaded package, the phpblog.sql file and execute it.

- To use this installation, you need to change informations in the phpblog/lib/OCFram/PDOFactory files: 
	(mysql:host=localhost;dbname=phpblog', 'root', ''). The 'root' parameter is the database acces pass and '' is the password.
	So your database has other pass or/and password, change as you need.

- For sending emails you must also modify parameters : in the App/frontend/module/Post/postsController file you must set your own infromations.

	

