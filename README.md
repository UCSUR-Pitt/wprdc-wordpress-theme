#WPRDC Wordpress Theme
A custom Wordpress theme for the Western Pennsylvania Regional Data Center.

### Requirements
* PHP >= 5.3.9
  * WinCache
  * cURL
* [Node](http://nodejs.org/)
* [Bower](http://bower.io/)
* [Composer](https://getcomposer.org/)

### Usage
Copy the contents of the `dist` folder to a new directory in your Wordpress themes directory (`wp-content/themes/`).

### Development Installation
1. `bower install && npm install && grunt build`
2. Create a symlink from the `dist` folder to your Wordpress themes directory

