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

The grunt command `sync:wordpress` assumes that WordPress is installed in the `public` directory. This works best with a virtual host/directory. After WordPress is installed to the `public` directory, you can setup the development environment by running:

`bower install && npm install && grunt build && grunt watch`

With `grunt watch` running, any changes to the `dist` directory will be pushed to `public/wp-content/themes/wprdc/`.

