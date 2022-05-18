Simple-CMS Blog with PHP
=======================

A a simple CMS project that uses PHP's fundamental, to create your own wordpress/blogs website. 

![unmaintained](http://img.shields.io/badge/status-unmaintained-red.png)

<p align="left">

<a href="LICENSE"><img src="https://img.shields.io/github/license/ayiedfarith/cms" alt="Software License"></img></a>
</p>


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See below for notes on how to deploy the project on your system.

## Prerequisites Installation

Below is the neccesary software that you need to download before running this project in your system, you need to make sure that all the software below  is succesfully installed.

```
1. (XAMPP/MAMPP/LAMPP)
2. Git
3. Composer
4. Mailtrap's (Open Mailtrap account and setup mailtrap based on your credential)
5. env environtment
6. Sublime, or any code editor
```
## Setting up your Database
Next, you need to create new database call `cms` at phpmyadmin, next you need to choose the newly created database, and you need to choose import. Afterward, you need to import `cms.sql` into Phpmyadmin. After importing you need to enter your own credential to the users table in `cms` database, so that you can login into the system without a problem, after that make sure you have created and setup `.env` files, you can check `.env.example` for more information. 

After all that is done, now you can login into your system.

## Authors

* **Farith Syariffudin** - ([ayiedfarith](https://github.com/ayiedfarith))

## License

This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/ayiedfarith/cms/blob/main/LICENSE) file for details


