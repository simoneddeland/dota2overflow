Dota 2 Overflow
=========

A website for asking and answering questions based on Stack Overflow. This project was created as part of a course at the university BTH in Sweden. The website uses the Anax MVC framework which was created by the teacher of the course.


Installation
------------------
Clone the project and make sure that your websites root directory is the webroot directory, the other directories should not be accessible for website visitors. The project uses an included SQLite database with some sample data. Should you wish to reset the database to that sample data, simply press "Setup" in the navbar. When the website is used in production the setup links should be removed from the navbar, and the SetupController should be removed from the index.php file in the webroot directory.