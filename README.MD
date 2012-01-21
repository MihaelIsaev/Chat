Chat
===========================

Distr Contents
-----------------------------------------------

* ajax/
   * ajax/
      * changeName.php
      * check.php
      * delete.php
      * disconnect.php
      * like.php
      * send.php
   * html/
      * chat.php
* classes/
   * chat.php
   * mysqliDB.php
   * simpleDB.php
   * sockets.php
* sockets/
* www/
   * content/
      * css/
         * style.css
      * fonts/
         * segoeui.ttf
      * images/
         * background/
            * sunrise.jpg
         * close.png
         * delete.png
         * heart.png
         * modalBackground.png
         * progressbar.png
      * scripts/
         * ajax.js
         * binder.js
         * chat.js
         * helper.js
         * html.js
         * jquery-1.6.2.min.js
         * jquery-include.js
         * jquery-ui-1.8.17.custom.min.js
         * system.js
         * visual.js
   * templates/
      * index.php
   * ajax.php
   * config.php
   * index.php

Install How-To
-----------------------------------------------

__1)__  Extract chat.zip

__2)__  Contents of the 'yoursite.com' copy to folder of your domain

__3)__  Create database 'chat' in MySQL and run chat.sql for create tables

__4)__  Open file 'classes/mysqliDB.php' and edit MySQL connection params

```
    $this->db_resource = new mysqli('localhost', //host
                                    'root',      //login
                                    '',          //password
                                    'chat'       //database
                                    );
```

__5)__  Enjoy!