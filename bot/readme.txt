+---------------------------------------------------------------------------
|   PHP-IRC v2.2.1 Service Release
|   ========================================================
|   by Manick
|   (c) 2001-2006 by http://www.phpbots.org/
|   Contact: manick@manekian.com
|   irc: #manekian@irc.rizon.net
|   ========================================
|   Special Contributions were made by:
|   cortex
+---------------------------------------------------------------------------
|   > Documentation
+---------------------------------------------------------------------------
|   > This program is free software; you can redistribute it and/or
|   > modify it under the terms of the GNU General Public License
|   > as published by the Free Software Foundation; either version 2
|   > of the License, or (at your option) any later version.
|   >
|   > This program is distributed in the hope that it will be useful,
|   > but WITHOUT ANY WARRANTY; without even the implied warranty of
|   > MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
|   > GNU General Public License for more details.
|   >
|   > You should have received a copy of the GNU General Public License
|   > along with this program; if not, write to the Free Software
|   > Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
+---------------------------------------------------------------------------
|   Changes
|   =======-------
|   > If you wish to suggest or submit an update/change to the source
|   > code, email me at manick@manekian.com with the change, and I
|   > will look to adding it in as soon as I can.
+---------------------------------------------------------------------------

NOTE! Please enable word-wrap to view this file.
NOTE! PLEASE READ SECTION '3. Installation - A few things to consider' BEFORE USING.

Please visit our new mods/forums website here: http://www.phpbots.org/

Table of Contents
-----------------

1. 	Introduction and Release Notes
1-a.	What's new in 2.2.1!
1-b.	Features
2. 	Included
3. 	Installation - A few things to consider
3-a.	Quick Install
3-b. 	Installing PHP 5
3-c.	Using alternate PHP.INI (PHP Configuration) file
3-d. 	Installing PHP-IRC
4. 	Configuration
5. 	Running
6. 	Remote Administration (via DCC and Private Message)
7. 	File Transfer
7-a. 	File Transfer behind a firewall or NAT
8. 	Modules and User-defined functions
8-a. 	Submitting modules for others to download
9. 	Querying outside servers (alternative to fopen, fsockopen, etc) READ THIS if you need this functionality!
9-a.	Basic Queries, using the addQuery() function
9-b.	Intro to Connection Class, Advanced Queries
10. 	Custom DCC Chat Sessions
10-a. 	Custom DCC Chat Example: Simple File Server (SFS)
11. 	Database support
11-a.	Mysql Database
11-b.	Postgre Database
11-c.	Serverless, mIRC compatible ini-file based Database
12. 	Timers
13. 	Multiple servers under one process
14.	Provided Sample Modules
14-a.	IMDB Parser
14-b.	Quotes mod with mysql/ini file system
14-c.	Simple http server
14-d.	Bash.org Parser
14-e.	News System/Rules Script
14-f.	Seen System (beta!)
14-g.	Request Ads System
15. 	Function Reference
16.	Special Thanks

=================================
1. Introduction and Release Notes
=================================
Please visit our new website: http://www.phpbots.org/ for support and user-submitted modules.

PHP-IRC is a totally php based irc bot meant to automate some applications related to irc.  I've personally programmed several modules which I currently use on irc.rizon.net.  This version is my attempt at bringing such a device to the public.  I hope you find it as useful as I do.  I have begun work on a module submission site which will be hosted at http://www.phpbots.org once finished.  I have already recieved modules from serveral enthusiastic people wishing to contribute in some way to the project.  Thank you for your time and effort.

It has always been my opinion that IRC scripting has long needed a simple programming interface that people with already existent skills could utilize.  There are two main reasons that PHP was selected as the primary language.  First off, I wanted to provide novice programmers a way to code their own functions and algorithms into a powerful platform without having to worry about such things as memory management and compilers.  Secondly, I wanted to do something that no one has done before--create a fully featured bot in php.   I don't know if I will ever complete the second objective, but I will keep on developing, as it will always be the main goal of this project.    

If I have left out information in this file, or there is something I said that confused you, please email me your concerns at manick@manekian.com, and I will try to clarify where you were confused.  This will also help me determine what I need to fix in this file for the next version.


=========================
1-a. What's new in 2.2.1!
=========================
As this is a service update and not a full release, the readme file included below has not been altered from the 2.2.0 version.  Version 2.2.1 brings several bug fixes (which are viewable in changes.txt).

Development on PHP-IRC is not halted, simply stalled, as I am approaching the culmination of my college career.  Thank you for your continued interest in PHP-IRC.

We have a new website!  Please view it here: http://www.phpbots.org/

=============
1-b. Features
=============
For a full list of current major features, please visit: http://www.phpbots.org/

===========
2. Included
===========

Core Files:
	==============
	Config Files
	--------------
	bot.conf
	function.conf
	typedefs.conf (added 2.2.0)
	modules/default/priv_mod.conf (added 2.2.0)
	modules/default/dcc_mod.conf (added 2.2.0)
	==============
	Readme Files
	--------------
	readme.txt
	modules/template.txt (added 2.1)
	gpl.txt (added 2.1)
	command_reference.txt (added 2.1.1)
	changes.txt (added 2.1.1)
	upgrade-2.1.1-2.2.0.txt  (added 2.2.0)
	install.txt  (added 2.2.0)
	==============
	Source code
	--------------
	bot.php
	chat.php (added 2.1)
	connection.php (added 2.2.0)
	dcc.php
	defines.php (added 2.0.1/2)
	error.php
	file.php (added 2.1)
	irc.php
	module.php (added 2.2.0)
	parser.php
	queue.php (added 2.2.0)
	remote.php (added 2.2.0)
	socket.php
	timers.php
	modules/default/dcc_mod.php (added 2.1)
	modules/default/priv_mod.php (added 2.1)

==========================================
3. Installation - A few things to consider
==========================================

I've been getting a lot of emails and private messages on rizon about how to run this bot via a web browser.  However, most webhosts do not compile php with socket support enabled, and for that matter, most web hosts don't have php5 as of yet.  Even so, in order to start the bot, you have to specify a config file on the command line.  Thus, running this bot from a web browser without modification is impossible.  I will not make this possible, so in other words, please stop asking.

Another thing that might deter people from using this script is the enourmous memory requirement by php to keep
a script loaded in memory.  PHP5 loads all of the program and everything it could possibly use into memory.  This can take up quite a bit of space!  I've had a bot use 8 megs of ram on the low end, and up to 15 megs on the high end.  If you don't mind dropping 15 megs of ram for this bot, then continue on.  Otherwise, don't whine to me that its a resource hog.  I believe the advantages far outweigh the disadvantages--how else could I have gotten this far?

In order to run this bot, you must have shell access to the box you will be running it on.  For instructions on how to install php5 for use with this bot, please see the next section, "Installing PHP 5".

A note about errno constants:
-----------------------------

In unix/windows/etc, when trying to write or read from a socket sometimes (a socket is the connection between your computer and another computer), errors occur.  In order to be able to determine what these errors are, all systems have something called 'errno' constants.  Unfortunatly, PHP5 does not know these constants, so we have to set them manually in order for this program to run.  In the defines.php file, I have set common values for windows, freebsd, linux, and unix.  If you are using one of these systems, an autodetection script should take care of detecting which system you are running the bot on, and set the appropriate values.  If this does not work, and you cannot connect to a server, you may need to set your OS type to either "windows", "freebsd", "linux", or "unix".  If you do not experience problems with this, then skip down to "Installing PHP 5".  Otherwise, keep reading.

I have run this successfully on Windows XP, Mandrake 9.0 Linux, and Debian.  If this program does not work with any of the os settings for OS in defines.php, you need to find the correct values for EAGAIN, EINPROGRESS, EALREADY, and EISCONN(these are those error constants that I was talking about earlier) for your system.

They are usually in /usr/include. You can find them by using a command sequence such as this:

-------------------------------------------------------------------------------
grep -r 'EAGAIN' /usr/include/*
grep -r 'EINPROGRESS' /usr/include/*
grep -r 'EALREADY' /usr/include/*
grep -r 'EISCONN' /usr/include/*
-------------------------------------------------------------------------------

After doing this, you'll get a line that looks like this:

-------------------------------------------------------------------------------
/usr/include/asm/errno.h:#define        EISCONN         106     /* Transport endpoint is already connected */
-------------------------------------------------------------------------------

The constant we are looking for is 106.  Now, after finding all those numbers, go into defines.php.  Set your OS type to "unknown"; then, scroll down a bit till you find this code:

-------------------------------------------------------------------------------
if ($OS == 'unknown')
{
	define('EAGAIN', 	0); 	/* Try again */
	define('EISCONN', 	0);	/* Transport endpoint is already connected */
	define('EALREADY',	0);	/* Operation already in progress */
	define('EINPROGRESS',	0);	/* Operation now in progress */
}
-------------------------------------------------------------------------------

Now, change the numbers, etc, with the corresponding values you got when you found the constants above.  Do this with all four constants, and then move on to the next section.

==================
3-a. Quick Install
==================

Running php-irc consists of 6 general steps (EXPERTS ONLY!):

1) Download and unpack, compile the php 5 5.0.2+ package with sockets and pcntl.
2) Edit the php.ini file following the steps in section 3-b (bottom half of section under "First, locate this line in the file:")
3) Unzip php irc
4) If the bot does not start up and connect to the server, you may have to set the OS parameter in the defines.php file.  Read the previous section.
5) Change server/port information in bot.conf.  You can run php-irc with the -c switch to get an md5 password hash to set dccadminpass with.
6) run php-irc with: /path/to/php/php.exe bot.php bot.conf from the php-irc directory, or edit the shebang line and change it to reflect your php location, (also use -c switch to specify php.ini location), and then chmod the bot.php file 755, and run with ./bot.php bot.conf

Of course, I recommend that you read the rest of this file, as it provides some very important information.

=====================
3-b. Installing PHP 5
=====================

Please read the following notices before continuing to install:

Notice 1:
---------
Do not use this bot with alpha/beta versions of php5.  I have successfully run it on rc2/rc3, however.

Notice 2:
---------
Do not use this bot with php 5.0.0 or 5.0.1.  These versions have a bug which makes it work incorrectly.  If you would like to find out more about this bug, view this page: http://bugs.php.net/bug.php?id=28892

Installation: (see below for installations on linux)

---------------------
Installing on Windows
---------------------
Download PHP5 from this location: 'http://www.php.net/downloads.php'.  Select the latest PHP 5 zip package under "Windows Binaries".  Unzip this to a folder, c:\php, for instance.

Then, copy the included 'php.ini-dist' file in the c:\php directory to 'c:\windows\php.ini'.  Open this file with notepad or your favorite text editor. (Usually, you can right click the file and hit 'open with').

First, locate this line in the file:
---------------------------------------------------------------------------
; This directive tells PHP whether to declare the argv&argc variables (that
---------------------------------------------------------------------------

A few lines below this, you'll see this directive:
--------------------------------
register_argc_argv
--------------------------------
Make sure that this line says:
--------------------------------
register_argc_argv = On
--------------------------------

Now, locate this line:
--------------------------------
extension_dir = "./"
--------------------------------
Change this to:
--------------------------------
extension_dir = "./ext"
--------------------------------

If you are going to use a mysql database, find:
------------------------
;extension=php_mysql.dll
------------------------
And change to:
------------------------
extension=php_mysql.dll
------------------------

Then find:
--------------------------------
;extension=php_sockets.dll
--------------------------------
And change to:
--------------------------------
extension=php_sockets.dll
--------------------------------

You are now set to run PHP-IRC.  See section "Configuration" for information related to configuring the bot.

-------------------
Installing on Linux
-------------------
Download php from php website, here: 'http://www.php.net/downloads.php'.  Select the latest php5 tar.gz package under "Complete Source Code".

Extract this file.  To do this, copy the file to your home directory.  Then, extract it using this command:

tar -zxf php-<your version>.tar.gz

Replace <your version> with your version of PHP.  Make sure it is 5.0.2 or greater!
Now, run this command:

cd php-<your version>/

Also make sure to replace <your version> with your php5 version.
Now, we have a few things to consider here.  Do you want to run a mysql database or not?  If you do, then use this command:

./configure --enable-sockets --enable-pcntl --with-mysql

However, if you do not have mysql installed on your system, do this:

./configure --enable-sockets --enable-pcntl

If for any reason this fails, please read below.  If it does not, skip these next few paragraphs.

Usually the configure script fails when it cannot find a module or package it needs to compile.  Sometimes I have had it fail with the 'XML LIB' package, saying it could not be found.  In order to rectify this, use this command:

./configure --help

And then search through the output, looking for the package that failed.  See if there is a --disable-<package> option that you can add to the ./configure command above, which will make it skip that package.  Then, run the configure command again, until you remove all packages that do not work with your system.

Continuing on
-------------

Now, after you see the "Thanks for using PHP" message, run the following command:

make

After this is completed, you are all done installing php!  You will need to copy the binary to a usable and NON WEB ACCESSABLE directory, by using this command:

cp sapi/cli/php /<my directory>/

Where <my directory> is the directory you wish to copy it to.  When I say NON WEB ACCESSABLE, I mean that you could not access this file directly from the web.

You are now set to run PHP-IRC.  See section "Configuration" for information related to configuring the bot.

=====================================================
3-c. Using alternate PHP.INI (PHP Configuration) file
=====================================================

You may be running another version of php on the server that you run this on specifically for apache, or some other purpose.  In this case, you already have a php.ini file in /etc.  You can use an alternate php.ini file by using this syntax when running php:

/path/to/php.exe -c /dir/of/php.ini/ bot.php bot.conf

If on linux, you can also chmod bot.php 755, and then edit the #! line at the top of the file to look like this:

#!/path/to/php -c /dir/of/php.ini/

And then you can run php-irc like this:

./bot.php bot.conf

=======================
3-d. Installing PHP-IRC
=======================
If you are reading this file, you have already downloaded and unpacked the source package from sourceforge.net.  Good, the hard part is out of the way.  Continue on to the next section.


================
4. Configuration
================

PHP5
----
Please see above, our guide to "installing php 5" for configuration options to php.ini.

defines.php
-----------
The main things you need to look at in here is DEBUG mode and OS. DEBUG 1 will make it so everything that happens to the bot is printed in the main window.  DEBUG 0 will instead print it to a logfile specified in bot.conf. Make sure that you set your OS to either linux, unix, windows or bsd, otherwise your bot won't run (if autodetection fails).

The lines you need to change are:

define('DEBUG', 1);

and:

define('OS', 'windows');

You might also want to change the name of the PID file that is written when you run the bot in background mode.  You can edit that filename with this line:

define('PID', "bot.pid");

bot.conf
--------
Edit this file and change all the options to your liking.  Of special interest should be natip, which allows you to work from behind a nat.  Also, as of 2.1, pay special attention to the 'upload' and 'uploaddir' parameters.  You can accept file transfers with those.  Please also look at dccadminpass.  You will need to set this in order to use dcc chat or private message administration of your bot.  You will need to run 'bot.php -c password' to generate an md5 password hash of 'password'.

function.conf
-------------
This file is a little more complicated.  php-irc will respond to various text typed in a channel (triggers).  You can configure those triggers in this file.  Please see the section titled "Modules and User-defined functions" for help with this file.

At this point, you should be able to start up your bot--although it won't do much.  See the section "Modules and User-defined functions" for information about adding functionality.


==========
5. Running
==========
Running this bot is rather simple.

Windows:
--------

Run the bot with the following command:

c:\php\php.exe bot.php bot.conf

Make sure that this is the correct path that php is in.  You may need to change 'c:\php' to the directory where your php5's php.exe resides.  Make sure, also, that you are located in your php-irc main directory when you start the bot. i.e.,

cd <my php-irc directory>

I have a little trick.  I make a windows shortcut (.lnk file) to php.exe, and put it in my php-irc directory.  Then I edit the shortcut and make sure that my working directory is my php-irc directory.  Then, I can run the bot as such:

php.lnk bot.php bot.conf

Linux:
------
The basic syntax is:

/path/to/php5/php bot.php bot.conf

If you followed my php5 installation instructions, /path/to/php5/ would be the <my directory> that we talked about earlier.

Linux Alternative:

You can edit the #! line in bot.php to reflect your php cgi binary location, and 'chmod 755 bot.php'.  This will make 'bot.php' executable.  You can then run it as such:

./bot.php bot.conf

You can also run several different configurations under the same process.  Simply make another bot.conf file and then run it like this:

./bot.php bot.conf bot2.conf

If you are on linux/unix, you can also run in the background by using the -b switch:
./bot.php -b bot.conf
However, in order for this to work, you need to set DEBUG mode to 0 in defines.php. (otherwise your bot won't spawn)  Also keep in mind that errors will not be displayed when in background mode.  Although text is logged to log.txt or whatever file you choose, the errors are not.  I will work on this for future versions.  However, if you're going to be doing a lot of debugging and are going to want to see all errors, you may want to keep DEBUG=1 and then use a program such as nohup to start the bot:

nohup ./bot.php bot.conf

If this doesn't work as expected, delete the 'fclose(STDOUT)' line in bot.php and try running it like this:

nohup ./bot.php bot.conf -b


======================================================
6. Remote Administration (via DCC and Private Message)
======================================================

You can administer your bot via private messages (i.e., /msg php-irc <command>), or via dcc chat interface.  However, in order to use these features, make sure that the 'dccadminpass' setting in bot.conf is uncommented, (remove the ';'), and make sure that you change the password to something people can't guess.  You need to specify a password hash here, and you can do that by running:

Windows
-------
drive:\path\to\php.exe bot.php -c <password>

*nix
----
/path/to/php bot.php -c <password>

Where <password> is your password you wish to use.  This will generate an md5 hash of '<password>', and you can replace the dccadminpass setting in bot.conf with this value.

Via private message, you can access admin commands like so (if you are using mIRC):

/msg <mybot> admin <mypass> <command>

Where <mybot> is the nick of your bot, <mypass> is the password you selected for dccadminpass, and <command> is the command you will use.  You can get a list of commands by using the command 'help'.

To use the dcc chat administration interface, use:

/msg <mybot> admin <mypass> chatme

The bot should then send you a dcc chat request.  You will have to type in your password to validate your session, which is just the password you set with dccadminpass again.  Then, you can type 'help' for a list of commands.


================
7. File Transfer
================

This bot supports file transfers now.  I will implement a speed capping system in a later version.  For right now, you can send/recieve files at your max bw potential.  Really fast transfers (in the line of 100 mbit) take up nearly 99% of your CPU, however.  The system supports resume, as well as the mIRC File Server protocol (see below for configuration)

To send someone a file, use: 

SEND <nick> /path/to/file

You can use 'DCC' for speed/eta, although it doesn't work very well. Its based off of 3 second averages. Oh, and you can use 'CLOSE id' to close a specific transfer.  These id's are the numbers between the brackets ([ and ]) when you run the 'DCC' command.

NOTE! This may be a security risk, as people with admin access could send themselves any file on your computer with it.  You may want to disable this function in the function.conf file if you feel this may be a problem. (just comment it out by putting a ';' in front of the line, or removing the line completely)

===========================================
7-a. File Transfer behind a firewall or NAT
===========================================

To setup the bot to work behind a NAT (i.e., you are a computer behind a router, and you do not have a net-accessable IP, like 192.168.1.100), you can use the 'natip' setting in bot.conf.  Then, you can set the 'dccrangestart'  item to choose what port file transfers will use for outsiders to connect.  Normally, the bot will use port 1024+, but if you are using forwarded ports, you can set this setting to use those ports.

If you are behind a firewall, and cannot use the natip feature:
This bot also supports the mIRC reverse dcc protocol.  The mIRC File Server protocol can be turned on by uncommeting the 'mircdccreverse' setting in bot.conf.  The 59 there is just the port that you will connect to.  Common numbers are 59 and 212.  

=====================================
8. Modules and User-defined functions
=====================================

Modules are what add the functionality to php-irc.  You can run php-irc by itself, and it may come with some pre-programmed features, but other than that it doesn't do much.  You need to extend it by adding modules that other people have written, or by writing modules yourself.  In this section, I will attempt to guide you through the process of doing just that.

Modules reside in the 'modules/' directory.  I have several modules in this directory already, and you can read about them in the section "Provided Sample Modules".

A php-irc module is a user defined class inside of a file in the modules/ directory.  See "template.txt" in the modules/ directory for instructions on how to setup a class.  The basic declaration of a module class is as follows:

class class_name extends module {

	//Other stuff, can be found in template.txt

}

This declaration syntax is INCREDIBLY important.  You MUST have the format:

class[space]class_name[space]extends[space]{

In order for the dynamic module support in PHP-IRC 2.2.0 to work, class definitions for modules must be defined in this way.  If you have outside classes to include, you must include them with "require_once()", instead of "require()".

Now, say that we created a module; we copied template.txt to my_mod.php, and changed "class_name" to "my_mod" inside my_mod.php.  Now, we will have to declare this module inside function.conf.

function.conf
-------------
There are three main types of directives that you can set in this file.  Types, Commands, and Includes.  A "Type" statement is a statement which declares a format for a "Command" to use.

For instance, if I had a type, "notice", and I wanted it to have the arguments "module", and "function", I would do this as follows:

type notice module function

Now, I can create commands that use type "notice".  Here is an example of a command that uses type "notice":

notice my_mod my_function

Thus, whenever a "notice" event took place on IRC, the function "my_function" in "my_mod" would be run with various useful parsed parameters passed. (Discussed Later)

Note the "module" and "function" arguments.  These are required arguments.  This means for every single type declared, there must be a "module" and "function" argument specified, because if these didn't exist, what would be the point of catching the event?

"Include" statements specify external function files to include into the main function.conf file.  They are useful when packaging a module with several function.conf statements.  Instead of copying/pasting all the statements on installation of the module, one need only to instruct a user to include a statement such as this:

include modules/my_mod.conf

Now to get a little more complicated:
-------------------------------------
In addition to parsing standard irc messages and events and defining functions to parse them, the bot comes with 4 standard types.  These types are "priv", "dcc", "ctcp", and "file". The "file" type is used to include module files and their associated functions into the bots runtime code.  The "ctcp" type makes parsing mIRC's "/ctcp" commands simpler.  This could also be done by using a "privmsg" type and then parsing the line manually (to remove the ctcp characters), but its simpler to just do it this way.  The "priv" type handles text typed in a channel.  Thus, we can capture "!ad" or other triggers with this.  The "dcc" type handles text typed in the standard user and admin dcc chat interface.

file
----
You use this to declare and include modules into php-irc.  The syntax is as follows:

file		- the type
name		- the module (or name of the class in the file)
filename	- the filename to include (the file that the class resides in)

Example:

file priv_mod modules/priv_mod.php

Filenames with spaces can be enclosed with quotes:

file priv_mod "modules/My totally kick ass mod.php"

priv
----
The "priv" type comes with several parameters, each explained below:

priv		- the type
name		- the trigger typed into the channel, i.e., "!ad"
active		- whether this particular function is active (can be triggered)
		  when the bot starts up
inform		- Inform the administrator (through dcc chat interface, when the admin
		  is logged in) that someone used this function.
canDeactivate	- admin can deactivate this function using FUNCTION command in dcc interface
usage		- how many times this function was used
module		- the module that the function is located in
function	- the function in the module specified above that is run

An example of a command that uses the "priv" type is defined below:

priv !ad true true true 0 priv_mod priv_ad

The "!ad" command uses the function "priv_ad" in the "priv_mod" module.  So whenever someone types in a channel:

!ad <some arguments>

The priv_ad function in priv_mod will be called to handle the arguments and respond to the user.

dcc
---
The "dcc" type comes with several parameters, each explained below:

dcc		- the type
name		- the command typed, i.e., "HELP"
numArgs		- the expected number of arguments for this command
usage		- a string containing an overview of arguments, i.e., "<id> <nick>"
help		- a string containing information about what the command does
admin		- whether this command is only available in the admin interface, or can be used in the standard user                    dcc chat interface
module		- the module that the function is located in
function	- the function in the module specified above that is run
section		- the section the command is displayed in in dcc chat interface (explained below)

An example of a command that uses the "dcc" type is defined below:

dcc raw 1 "<raw query>" "Sends raw query to server" true dcc_mod dcc_raw standard

You might also notice that in this case we used quotes.  Quotes can be used for any string longer than 1 word.  Single and Double quotes are allowed.  Escape double/single quotes inside the quotes with a backslash: i.e., "Who\'s there?".  This does not follow the standard convention for escaping quotes.  So, even if you use double quotes to specify a multi-word string, you must still escape single quotes.

section
-------
In the dcc command above, the "section" argument was used, and specified as "standard".  PHP-IRC 2.2.0 comes with a new ability to package dcc commands with sections.  Thus, when someone types "Help" in dcc chat, all of the functions are organized by category.

A section can be declared with the following arguments:

name		- a small idname to be used in 'dcc' statements
longname	- a usually quoted string which speicfies this sections title

PHP-IRC comes with a few pre-defined sections which include 'standard', 'channel', 'dcc', 'info', 'admin', and 'comm'.  The declaration for the standard section type is shown below:

section	standard "Standard Functions"

You can of course specify your own sections in the same manner; say, for a custom module perhaps.

ctcp
----
This is a shortcut to parsing commands sent to this bot with mIRC's /ctcp command.  The format is as follows:

ctcp		- the type
name		- the trigger, i.e., "files" (see fileserver example in function.conf)
module		- the module that the function is located in
function	- the function in the module specified above that is run

See the fileserver ctcp command in modules/fileserver/fileserver.conf for an example.

Now that you know what function.conf is and how it works:
---------------------------------------------------------

Suppose we have a random function in a module we've written, such as the one defined in the next section titled "Querying Outside Servers" named "query".  Having the functon is all fine and dandy, but how do we access it?  That is where function.conf comes in.  We will specify a trigger which can be used to access the query function during runtime.  First, we have to include our module:

file my_mod modules/my_mod.php

We'll pretend that this is where the 'query' function resides for the moment.  Now, lets say we want to run that function every time someone types '!info' in the channel.  To do this, we would add (below all the type declarations, and below the 'file' declaration we just made above):

priv !info true true true 0 my_mod query

Thus, every time someone typed !info in the channel, the function 'query' would run.  This is the main basis for php-irc.  It is the heart of its purpose--responding to triggers.

Creating Functions to Respond to Triggers
-----------------------------------------
Now that you know how to create modules, and specify them in function.conf, we will now cover writing your own functions to handle these triggers.  There are four main types of functions that you will write.  "timer" functions, "standard" functions, "query" functions, and "dcc" functions.

standard
--------
Standard functions are the functions which handle all the non-dcc type command statements declared in function.conf.  Remember our example earlier, when a user could type '!info' in the channel.  This triggered the 'query' function in the module 'my_mod'.  A sample declaration of this function could be:

  public function query($line, $args)
  {
    //your code
  }

Notice the "$line, $args".  The declarations for 'query', 'dcc', and 'timer' functions all use different values here.  They are shown below:

  public function standard($line, $args)
  public function query($line, $args, $result, $response)
  public function timer($arguments)
  public function dcc($chat, $args)

Definitions of variables
------------------------

$line
-----
Line is an array containing a parsed version of the raw line sent from the server.  A raw line sent from the server could look like this:

:Manick!~bugs@Rizon-2EFC6E17.resnet.purdue.edu PRIVMSG #manekian :!ad

We need to parse this into meaningful parts in order to do anything with the bot.  The $line array does that:
from		=> full nick/ident/host, in this case: "Manick!~bugs@Rizon-2EFC6E17.resnet.purdue.edu"
fromNick	=> only nick, in this case, "Manick"
fromHost	=> only host, in this case, "Rizon-2EFC6E17.resnet.purdue.edu"
fromIdent	=> The Ident of the user, in this case, "~bugs" 
cmd		=> irc command used, (i.e., PRIVMSG, NOTICE, 366, 353, etc), in this case "PRIVMSG"
to		=> who this command was directed at (channel or your nick), in this case, "#manekain"
text		=> everything after : in the line; basically the text of what someone says, in this case, "!ad"
params		=> useful when parsing 'mode' commands etc. in this case, ":!ad"
raw		=> the full untouched line.

To access an element in $line, reference it as such:  $line['element'], such as: 

$line['fromNick']

This would return "Manick", in this case.  Sometimes these variables are not populated perfectly.  In a particular circumstance, you can use:

print_r($line);

by itself to to print the contents of the $line variable to the screen while in debug mode.

$args
-----
This is a simple array created from the $line['text'] variable.  It contains the following data:

nargs		=> the number of arguments
cmd		=> the command used
arg1		=> present if there are 1 arguments or more
arg2		=> present if there are 2 arguments or more
arg3		=> present if there are 3 arguments or more
arg4		=> present if there are 4 arguments or more
query		=> The full text (all of args put together)
(there are no more after arg4..)

So, if I typed "!ad 60 Here is an ad that I want to talk about...":

nargs would be "4" (yes, 4)
cmd would be "!ad"
arg1 would be "60"
arg2 would be "Here"
arg3 would be "is"
arg4 would be "an"
query would be "60 Here is an ad that I want to talk about..."

The maximum arguments can be set by the MAX_ARGS define in the defines.php.  It was chosen to be four for performance reasons.

$result
-------
This is discussed in the next section "Querying Remote Servers"

$response
---------
This is discussed in the next section "Querying Remote Servers"

$arguments
----------
When creating a timer,  you can specify one argument, whether it be a string, array, or object, to send to a timer function every time that timer runs.  Timers are discussed in a later section.

$chat
-----
This is the object containing the current session of the user who typed the command in the dcc chat window.  $args for dcc functions is the same as $args above.

Sending messages and responding to users
----------------------------------------

After you've received a query and processed it, you might want to send back information.  There are several functions that can be used to do just that:

$this->ircClass->sendRaw($text); //send raw data to server
$this->ircClass->notice($line['fromNick'], $text, $queue = 1);  // (where $queue defaults to 1.. meaning its not
								// sent right away.
$this->ircClass->privMsg($line['fromNick'], $text, $queue = 1); // $line['fromNick'] can also be the channel
								// which is usually $line['to'].
$this->ircClass->action($line['fromNick'], $text, $queue = 1);  // does the '/me' thing that mIRC does

To send data to dcc users, use:

$chat->dccSend("text here"); 

To send a CTCP messege, do this:

$cmd = "VERSION";
$msg = "";
$this->ircClass->privMsg($line['fromNick'], chr(1) . trim(strtoupper($cmd) . " " . $msg) . chr(1));

Where $cmd is the command, like "VERSION", or "ACTION", and $msg is the parameters to the command.

$queue
------
php-irc maintains a text queue, so that it does not flood the server with text.  This is not a perfect system, and still fails ocassionaly, but works for the most part.  If $queue is set to 1, or not specified at all, then $text will be appened to the end of the queue waiting to be sent to the server.  Otherwise, if you set it to 0, it will be prepended to the beginning of the text queue.


Now you should know all you need to know to write your own modules for php-irc.




==============================================
8-a. Submitting modules for others to download
==============================================

I am currently working on a site to submit modules.  This site will be http://www.phpbots.org when finished.

===========================
9. Querying outside servers
===========================

You may need to read the section titled: "Modules and User-defined functions" before reading this.

Sometimes when programming a module, you might find it necessary to parse some webpage to return some data to a user requesting it.  Your first impression might be to use "fopen" or "fsockopen" to make a connection to the webserver and get the data.  

Consider something for a moment.  This bot is running on one process, one thread.  Say that you were sending a file to someone, and you also went to query a webpage.  What if the webpage was extremely bogged down with traffic?  The query would block, and the file transfer would stall.  To rectify this, I implemented a few procedures for querying outside servers, including webservers.  This eliminates the blocking problem, as the connections are handled by php-irc.

There are two basic ways to communicate with the outside world easily in PHP-IRC.

1) Use $this->ircClass->addQuery()
2) Utilize the connection class manually

The addQuery() method is a specialized way of using the 'connection' class to get the job done.  In other words, you could write your own connection.php class method that does exactly what addQuery does, or even more if you wanted.  The irc bot itself uses the connection class to connect to irc servers, run dcc chats, and even run file transfers.  You can even use the connection class to start a listening socket, which can be used to write servers such as http servers, ftp servers, or pretty much anything that uses a tcp socket.

=================================================
9-a. Basic Queries, using the addQuery() function
=================================================

This method is used mostly for retrieving data from http servers.  It's main advantage is that it is incredibly easy to use, but the main disadvantage is that you can only send one query per connection, and then data related to that query is returned before the connection is terminated.

The basic procedure is this:  You will run a function with a query, and specify what function to run when data has been recieved from that server.  Then, the function, using a specifically defined prototype, will have access to all the data + results from the server as soon as the query is complete.

Functions used in this process are:

irc::addQuery($host, $port, $query, $line, $class, $function)
socket::generateGetQuery($query, $host, $path, $httpVersion = "1.0")  <-- $httpVersion can be omitted
socket::generatePostQuery($query, $host, $path, $httpVersion = "1.0") <-- $httpVersion can be omitted

These functions, (addQuery, generateGetQuery, and generatePostQuery) are outlined in the command_reference.txt file.  But here is how it works:

For instance, if you wanted to parse data at animenfo.com, you would do this:

Define a function in your module file.  We'll call it "query" for now.  Also, see the previous section for information about how to make this method accessable (by editing function.conf)

  public function query($line, $args)
  {
    $query = "search=naruto&queryin=anime_titles&action=Go&option=smart";
    $getQuery = socket::generateGetQuery($query, "www.animenfo.com", "/search.php");
    $this->ircClass->addQuery("www.animenfo.com", 80, $getQuery, $line, $this, "queryTwo");
  }

Notice the "queryTwo".  Now define another function in your module file.  We'll call it "queryTwo".

  public function queryTwo($line, $args, $result, $response)
  {
    
  }

The function, "queryTwo" will be run as soon as a response is recieved from the server, and the response will be stored in the '$response' variable.  The result of the query will be stored in the '$result' variable.  For instance, if there was an error on query,  $result will equal QUERY_ERROR, and the error message will be stored in $response.  If there is no error, $result will equal QUERY_SUCCESS.

Notice
------
As of version 2.1.1, the socket::httpGetQuery, and socket::httpPostQuery functions were removed.  They were replaced with the addQuery function.

================================================
9-b. Intro to Connection Class, Advanced Queries
================================================

As the development of PHP-IRC 2.2.0 continued, a need for a connection layer to the socket class appeared.  Code was being repeated often in the irc bot class, the dcc class, and other places; in addition, it was becoming quite cluttered and hard to understand.  Also, the old way just simply didn't work anymore with the process queue method implmented in 2.2.0.  Therefore, the connection class was implemented to solve this problem.

The connection class serves as a layer between the socket class and the user.  A user can create a connection, specify a host and port, and the connection class will do everything else automatically; connect, send read/write events, accept connections, close connections, and much more.  This works by specifying a callback class, with pre-named, user-defined functions to accept events from the socket class.  Say, for example, whenever data is read for a specifc socket, that sockets user-assigned connection class will notify the callback class of an event, say, onRead(), and then the onRead() function in the callback class can read the data.

Here's a simple schematic:

+--------------+            +------------------+            +----------------+
| Socket Class |->Triggers->| Connection Class |->Triggers->| Callback Class |
+--------------+            +------------------+            +----------------+

The callback class can then use socket class functions, such as getQueueLine(), or what have you, to retrieve data from the socket read queue, or send data using the appropriate function.

General Overview
----------------
There are two specific ways to run the connection class:

1) Open connection to other server specifying host and port
2) Listen for connections on a specific or random port, accepting new connections

The ins and outs of the callback class will then be explained.

Method One - Connecting to another server
-----------------------------------------
For this method, one needs 3 things, with the fourth being optional:

1) Host
2) Port
3) Connection timeout 
4) Transfer timeout

The connection timeout is how long before the connection class will think that it cannot connect to the server before timing out, and the transfer timeout is how long (after a connection has connected) before the connection class believes the connection to have failed after no activity.

Say you wanted to connect to "www.animenfo.com" on port "80".  First, you need to declare a new connection:

  $conn = new connection("www.animenfo.com", "80", CONNECT_TIMEOUT);

CONNECT_TIMEOUT is just the default connect timeout used by the irc class.  You can use whatever integer/float number you want.

  $this->conn = $conn;

You need some way of remembering this connection; in this case, the call back class will be the one that the connection is created in.  In most cases, you will need to make a whole new class because of the need for unique functions to handle the events of any general connection.

  $conn->setSocketClass($this->socketClass);
  $conn->setIrcClass($this->ircClass);
  $conn->setTimerClass($this->timerClass);

The connection class needs access to these three classes, socket class, irc class, and timer class.

  $conn->setCallbackClass($this);

This is probably the most important call of all.  Whenever an event happens for this connection, specific functions in this class will be called to handle the event.  This is explained more thouroughly below in the "Ins and Outs" of the callback class sub-section.

  $conn->init();

This will try to create the socket with the socket class.

Also, optionally here you can specify transfer timeout.  That would look like this:

  $conn->setTransTimeout($timeout);

Where $timeout is in seconds or fractions of seconds.

  if ($conn->getError())
  {
    $this->ircClass->notice($line['fromNick'], "Error connecting: " . $conn->getErrorMsg() );
  }

If there was a problem init()'ing the connection, then $conn->getError() will be true, and $conn->getErrorMsg() will be why.

  $this->sockInt = $conn->getSockInt();

The sockInt is necessary to use socket class functions for this socket.

  $conn->connect();

The final step, this will start the connection process to the server.

Method Two - Listening for Connections
--------------------------------------
This method follows reletively the same method as for connecting to a server.  There are two slight differences:

1) Specify the host as null when creating a connection, and specify the connect timeout as zero.

  $conn = new connection(null, "80", 0);

You can change the "80" to null to listen on a random port.

2) Do not run $conn->connect();

This function is used ONLY when connecting to a server.  It has no purpose otherwise.

The Ins and Outs of the Callback Class
--------------------------------------
Okay, so now we know how to create a listening connection or a connect connection.  Now what do we do with it?  We have to have some way of responding to the events.  A callback class must have seven pre-named functions:

class my_class {

  public function onTransferTimeout($connection)
  {
  }

  public function onConnectTimeout($connection)
  {
  }

  public function onConnect($connection)
  {
  }

  public function onRead($connection)
  {
    return true; (or return false;)
  }

  public function onWrite($connection)
  {
  }

  public function onAccept($listener, $newConnection)
  {
  }

  public function onDead($connection)
  {
  }

}

Each function is pretty self explanitory.  The only one that might cause some confusion is onRead() or onAccept().

onRead()
--------
This function returns true if not all data has been read from the socket (i.e., you used socketClass->getQueueLine() but want to give other processes a chance to run before you continue processing).  This will make the function run immediately again.  Otherwise, returning false will signal to the connection class that you don't need to run this function again.

onAccept()
----------
Listener is the connection that was listening for new connections, and $newConnection is the new connection.  $newConnection is another object of type connection class, and all one needs to do is call getSockInt() on it to get the socket identifier.  The callback class is automatically its parents callback class ($listener's callback class).  This can be changed by runing the setCallbackClass() function again with a different class.

Closing a connection
--------------------
This is very important.  The connection class will, under no circumstances, close a connection.  Even if the onDead() function is called, for instance, the callback class MUST close the connection.  If you have a connection, $conn, and you want to close it, you would run:

$conn->disconnect();

This kills the socket, and removes it from the socket class.  From this point on, it is completely inactive.

What if I want to accept a connection, but close the parent connection in the process?
--------------------------------------------------------------------------------------
The dcc class is a sample class that does just this.

  public function onAccept($oldConn, $newConn)
  {
    $this->conn = $newConn;
    //We just want to use $newConn from now on

    $this->sockInt = $newConn->getSockInt();
    //Get $newConn's sockint

    $oldConn->disconnect();
    //Close our old connection

    $this->onConnect($newConn);
    //Trigger the onConnect event
  }

============================
10. Custom DCC Chat sessions
============================

A custom dcc chat handler is where you send out a chat request to a user, and instead of php-irc's default dcc interface handling and parsing the input, you will handle and parse the input yourself.  Just follow the template.txt in the modules directory to create your handler.  However, in addition, you need to do a few extra things.

You will need to include these functions:

  public function main($line, $args)
  {
    $port = $this->dccClass->addChat($line['fromNick'], null, null, false, $this);

    if ($port === false)
    {
      $this->ircClass->notice($line['fromNick'], "Error starting chat, please try again.", 1);
    }
  }

  public function handle($chat, $args)
  {
  }

  public function connected($chat)
  {
  }

  //Following function added for 2.2.1
  public function disconnect($chat)
  {
  }
  
'main' function
---------------
This is the function that your trigger in function.conf will call to initiate the chat

'handle' function
-----------------
Whenever something is typed in the dcc chat window, it will be passed to this function in the '$args' array.  See the previous section for the general definition of this array.

'connected' function
--------------------
Use this function to do any "upon connection" tasks, as in setup the session or whatever you want.

fileserver.php is a module that uses a custom dcc chat handler, and is detailed below.


'disconnected' function
-----------------------
This is called when a dcc chat session is closed.

==============================
10-a. Simple File Server (SFS)
==============================

I've include a small, not-to-complex fileserver which you can use as an example to create your own modules. This particular one is a custom dcc chat handler (refer to previous section).  To activate, uncomment the  'ctcp files' section and 'file fileserver' section in the function.conf (you can change 'files' to whatever you want, its your trigger).  Then edit these variables in fileserver.php:

private $vDir = "F:/BT/"; (use forward slashes, with a trailing slash as shown)
private $maxSends = 3;
private $maxQueues = 15;
private $queuesPerPerson = 1;
private $sendsPerPerson = 1;

vDir is the root directory of the fileserver.  I haven't beta tested this too much.  If it breaks, tell me I guess.  It was meant as a demonstration rather than something to actually be used.

====================
11. Database support
====================

PHP-IRC offers ever increasing database support.  It currently offers a tried and tested mysql database abstraction layer(dba), and a beta postgre dba.  There is also a new "ini" database type which operates out of ini files.  This is similar to mIRC's /writeini and $readini functions.

=====================
11-a. MySQL Database
=====================

To use a mysql database, you will need to uncomment and fill out the database settings in bot.conf.  You will also want to make sure that you have php set to use mysql.  View the "Installing PHP 5" section for more information about this.

You will need to set 'usedatabase' in bot.conf to this:

usedatabase mysql

INPORTANT DATABASE INFO:
------------------------
Because PHP does not escape input from sockets as it does with get/post/cookies (from http), you need to escape your database information before you put it into the database.  Therefore, if you have a table with 3 fields like ... name, password, email, then the safest way to put this information into  the database using the db class provided in the bot would be:

$fieldArray = array("Somebody's Name", "somePass", "something@something.com");

$this->db->query("INSERT INTO sometable (name,password,email) values ('[1]','[2]','[3]')", $fieldArray);

This ensures that the data is safe to put into the database.  The [1] etc will be replaced with their place in the array above in real time.  Of course, you are free to do it however you wish.

======================
11-b. Postgre Database
======================

You will need to set 'usedatabase' in bot.conf to this:

usedatabase postgre

Also, read "IMPORTANT DATABASE INFO" above for more information.  Support for this dba is SKETCHY at best.

=========================================================
11-c. Serverless, mIRC compatible ini-file based Database
=========================================================

INI-file support compliments the database system provided by PHP-IRC.  Say you have a simple module which only needs to store a few data to file.  Instead of having to have a mysql database, you can achieve this feat with ini files.  They are basically identical to mIRC ini files--so, if you have any experience with $readini or /writeini, you will be pretty well off.

To use ini files, there are several functions you can perform:

1) Declaring, Creating, or Opening an INI file
2) Setting ini values
3) Retrieving ini values
4) Writing changes to ini file
5) Miscellaneous ini-file functions.

1 - Declaring, Creating, or Opening an INI file
-----------------------------------------------
Creating or opening an ini file is incredibly simple.  In fact, they consist of the same step:

$myIni = new ini("somefile.ini");

Thats it!  Then:

if ($myIni->getError())
{
	//some code to handle ini file error
}

If this is false, then the ini file cannot be created.  In this case, you need to check the permissions on the directory you're attempting to create this file. (It may be that you don't have read access either.)

Now you are ready to import/export data.  One idea you may use is saving the $myIni variable in a global variable in your module, and then using it just as if it was a database, running queries and updating data occasionally.

2 - Setting ini values
----------------------
INI files consist of three types of data.  Sections, Variables, and Values.  They look somewhat like this:

[section]
variable=value
another_variable=value
[section2]

etc....

To set an ini value on ini-object "$myIni", use the following function:

$myIni->setIniVal($section, $variable, $value);

None of these arguments may contain a newline character.

3 - Retrieving ini values
-------------------------
There are many many ways of retrieving data from an ini object.  To assist, there are around ten helper functions:

1) getSections() //get all section names
2) sectionExists() //check whether a section exists
3) getSection() //get all vars in a section, associative array form
4) randomSection() //get a random section
5) randomVar() //get a random variable in a section
6) searchSections() //see command_reference.txt
7) searchVars() //see command_reference.txt ... etc
8) searchSectionsByVar()
9) searchVals()
10) numSections()
11) numVars()
12) getVars()

Perhaps the most important function is getIniVal($section, $var).  See command_reference.txt for more detailed function information.

4 - Writing changes to ini file
-------------------------------
When you want to finalize changes to an ini database, and write the data to a file, call this command:

$myIni->writeIni();

This will write the ini file.  You can continue editing, and then use this function again as many times as you wish.


5 - Miscellaneous ini-file functions
------------------------------------
There are some other useful functions.  See command_reference.txt for more info.

1) deleteVar($section, $var)
2) deleteSection($section)
3) getSection($section)

==========
12. Timers
==========

Timers allow you to run some procedure or function later, but not have to actually "run" it later.  You specify a delay, and the script will run it in the interval selected.  Timers are used all over php-irc.  The point here is that you can also use them.  

Timer functions look like this:

  public function myfunc($arguments)
  {
	return true/false;
  }

This form is declared more readily in the section titled "Modules and User-defined functions".  By default, a timer will expire upon running, and will not be run again.  To change this so that the timer runs again in another interval, the timer function MUST return 'true':

return true;

This will signal the timer class to run the timer again after 'interval'.  Otherwise, the timer is removed.

If I wanted to create a timer to run a function in sixty seconds, I would do this:

$this->timerClass->addTimer("my_timer", $this, "myfunc", "", 60, false);

The arguments are as follows:
$name		- The timer's name.  Used with removeTimer to remove the timer
$class		- pointer to class with function, usually '$this'
$function	- the function that you will want to run after the interval expires
$args		- the arguments you want to send to the timer
$interval	- duh, in seconds and fractions of seconds (i.e., 5.2)
$runRightAway	- whether this timer should run as soon as it is added, or wait until after the interval. 'true' or 'false'.

A few notes:
------------

$name
-----
If you want to create a random name to send as timer title, with least chance for name collision, use:

irc::randomHash();

This function will generate a string which should be unique.

$args
-----
This can be anything you want, from a class, to an array, to an object.  I have the 'argClass' defined in defines.php which I use to send multiple variables to my timers:

$args = new argClass;

$args->arg1 = "blah";
etc...

Otherwise, you could just send an associative array.

Removing Timers
---------------
In order to remove a timer, you will need to use this function:

$this->timerClass->removeTimer($name);

The "$name" variable is the same as the name variable declared with addTimer above.  Make sure that you specify unique timer names.  Also, make sure that you keep track of the timer name if you are going to want to delete it.  You can usually do this by sending it via the $args variable.

Instead of relying on removeTimer, I many times simply return false instead of true when the timer is next run.  That is also possible.

===================================
13. Multiple bots under one process
===================================

This script supports running multiple bots under one process.  In order to do this, create another bot.conf file, say, bot2.conf, and just specify it when starting the bot:

./bot.php bot.conf bot2.conf bot3.conf

etc.  See the "Running" section for more information.  Performance of multiple bots has been significantly increased in 2.2.0.


===========================
14. Provided Sample Modules
===========================
To foster continued support of PHP-IRC; I have included some basic module examples in this release.  Please note that a parser can and will fail when the html of a site is changed, so some of these releases may NOT work at future dates.  They all worked previous to 01/14/05, however.

=================
14-a. IMDB Parser
=================
This module parses the internet movie database, http://www.imdb.com 

To use, uncomment the following line from function.conf

;include modules/imdb/imdb_mod.conf

The command is "!imdb".  You can do a search by using "!imdb <query>".  If multiple dates were found for your query, you can do: "!imdb <title> (date)" to see it's results.  Note that the parenthesis on the date must be there.

Note, as this is a parser, it may not work out of the box, as imdb might have changed their site.

===========================================
14-b. Quotes mod with mysql/ini file system
===========================================
Possibily the most usable feature of any bot, this bot comes with two different forms of quote systems.  You can either utilize a mysql database, or use the onboard ini file database.

Mysql
-----
To use, uncomment in function.conf:

;include modules/quotes_sql/quote_mod.conf

You must also set the database information in bot.conf, and run this query in the database:

create table quotes (id int default null, deleted tinyint(1) default 0, author varchar(50) default "", quote text, channel varchar(100) default "", time int, key(id));

See modules/quotes_sql/quotes_mod.conf for usable commands.

Ini
---
To use, uncomment in function.conf:

;include modules/quotes_ini/quote_mod.conf

Quotes are stored in the included "quotes_database" directory.

See modules/quotes_ini/quotes_mod.conf for usable commands.

========================
14-c. Simple http server
========================
Alright, this is more of a proof of concept than something actually usable.  This shows off the use of PHP-IRC's new "connection" class to handle incoming http connections in an event based way.

I really know just about nothing about the http protocol, thus I give no support or instructions for this module.  I have had it display pages and images with much success.

To use, uncomment in function.conf:

;include modules/httpd/httpd_mod.conf

Then, the bot will listen on the port specified in modules/httpd/http.ini which defaults to 5050.

=====================
14-d. Bash.org Parser
=====================
This will allow users to display random, searched, or specific quotes from http://bash.org

The commands are:

!bash - random quote
!bash + - random positive quote
!bash search - search for a quote, will display the first result containing 'search'
!bash id - will return the specific quote with id 'id'.

To use, uncomment in function.conf:

;include modules/bash/bash_mod.conf

==============================
14-e. News System/Rules Script
==============================
This is a small standard script where users can type a trigger and information will come back to them.  It can be used to generate !rules scripts, !news scripts, or pretty much anything you can think of.  To use it, uncomment the appropriate line (referring to news_mod.conf) in function.conf.  Then, you can use the default trigger, !news, to add stuff.  You must be opped/admined to add/delete items.

Here are the commands:

!news <command> <arguments>

command:
add - add a new item to end of list.  You can also add to a specific line number, by doing add <num> <stuff>
del - delete a line number: del <num>
show - show line numbers with their respective lines, so you can use del.
clear - clear out all lines for a specific channel.

Running the command with no arguments is available to everyone, and will show the lines in order of line number.

The usefulness of this mod is very apparent.  However, to make it even more useful, I've added another feature.  Say that you have these two items in news_mod.conf:

priv !news true true true 0 news_mod priv_news
priv !requests true true true 0 news_mod priv_news

Both of these are pointing to the same function/module, but they will both access separate database files.  Thats right, separate.  That is because any call to the function will make the function open the database that is of the same name as the trigger.  For instance, doing:

!news add Hello! This is some news!

This will add the line to the news database.  And doing:

!requests add Some Request

This will add the line to the requests database, but they use the same module/function!  Cool huh :)

===========================
14-f.	Seen System (beta!)
===========================
This is a very beta mod which I wrote like 15 minutes prior to releasing this version of php-irc.  Basically, it works as a normal seen mod would, you type !seen <user> and it tells you the last time it saw that person.  It uses the ini file system to store information.  This mod is VERY BETA!!! I haven't even tested 85% of it.  I ran it once and thought, "heh, interesting", and never looked at it again.  I will not support this mod until either someone updates it and sends me a better revision, or I get the time to make it better.

========================
14-g. Request Ads System
========================
This has been around since the early days of php-irc.  It is the classic example.  Except in 2.2.0, it now utilizes the ini file system, so ads that are added are saved and restarted when the bot process is killed and restarted.  The "!ad" trigger is on by default.

======================
15. Function Reference
======================
Please view the "command_reference.txt" file for a complete indepth look at all the functions that you can use while writing your modules.

==================
16. Special Thanks
==================
I would like to thank some of the recent regulars to #manekian @ irc.rizon.net for helping beta test this release:

ho0ber
nefus

=====
PS...
=====
Circular references are the devil!