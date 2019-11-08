# ToDoList & co 
========

this porject is created as part of a PHP / Symfony application developer training, using symfony 3.4 ,

## General idea around project
improvement of an existing project :
<p>the implementation of new features;</p>
<P>the correction of some anomalies;</p>
<p>the implementation of automated tests.</p>

<p>It is also requested to analyze the project with tools allowing you to have an overview of the quality of the code and the different axes of performance of the application.</p>

## The quality of the code

<a href="https://codeclimate.com/github/samirdev2019/toDo-co/maintainability"><img src="https://api.codeclimate.com/v1/badges/a9bb190e56b3c9bae967/maintainability" /></a>

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c66a130312a94f209fe0ce95d0d9cbf6)](https://www.codacy.com/manual/samirdev2019/toDo-co?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=samirdev2019/toDo-co&amp;utm_campaign=Badge_Grade)


## ToDo & co require & use
<p>1- PHP 5.5.9 or an version ulterieure to run</p>
<p>2-Mysql ~5.7.23</p>
<p>3-phpunit ^8.4</p>
<p>3- Bootstrap 4</p>
<p>4- jquery-3.2.1</p>


## How to install the project

### 1 - Download or clone the repository git form
<pre><code>git@github.com:samirdev2019/toDo-co.git</pre></code>

### 2 - Download dependencies 
<pre><code>composer install</pre></code> 

### 3 - Create database 

<pre><code>php bin/console doctrine:database:create</pre></code>

### 4 - Create schema 
<pre><code>php bin/console doctrine:schema:update --force</pre></code>

### 5 - Load fixtures
<pre><code>php bin/console doctrine:fixtures:load</pre></code>

### 6 - Run the server
<pre><code>PHP -S localhost:8000</pre></code>

### 7- create data base and fixtures in test envirenement
<p> add  --env = test  at the end of each line-command mentioned above 
<pre>
<code>php bin/console doctrine:database:create --env=test</code>
<code>php bin/console doctrine:schema:update --force --env=test</code>
<code>php bin/console doctrine:fixtures:load --env=test</code>
</pre>
<h4> 8- User registred</h4>
<pre>
<code>
administrator
<p>username : admin</p>
<p>password : admin </p>
<P>user</p>
<p>username : user</p>
<p>password : admin </p>
</code>
</pre>
<h4> 9-unit tests </h4>
<pre>
<code>
vendor/bin/phpunit
or
vendor/bin/simple-phpunit
</code>
</pre>