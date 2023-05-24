# install 
Use PHP: 7.4.29 and Opencart: 3.0.3.6

Be sure that you have enable on apache httpd.config LoadModule rewrite_module modules/mod_rewrite.so
on  .htaccess  ->I have put these:
RewriteEngine On: Enables the Apache mod_rewrite module.
RewriteBase /openchart/: Specifies the base URL path for rewriting. Adjust it according to your application's location. 
RewriteCond %{HTTP_HOST} !^www\. [NC] (optional): Redirects non-www URLs to www URLs.
RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L] (optional): Performs the actual redirection to www URLs.
RewriteCond %{REQUEST_FILENAME} !-f and RewriteCond %{REQUEST_FILENAME} !-d: Checks if the requested file or directory does not exist.
RewriteRule ^(.*)$ index.php?route=$1 [L,QSA]: Rewrites the URL to pass the requested route as a parameter to index.php.

# Install the database  that I send you !!

# After install it log in on admin panel with credential that i send you in email
1. Open the SEO URL.
2. Unstall my custom module with name  -> Product Average Rating.
3. Install it again to be sure that working ok.-> in order to fix it i make model, controller on admin of course
4. My custom page is https://www.localhost/openchart/products-eight ->in order to fix it i make model,controller, view on catalog of course
5. The product that I found that had size on default is the product with id 42. The size was in radio format and I made  a function that checks if it is in stock if not it sends a message out of stock.

# Thank you !!