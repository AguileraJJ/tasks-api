# Use an official PHP image as base
FROM php:apache

# Enable the rewrite module
RUN sed -i '/#LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf

# Allow .htaccess overrides
RUN sed -i '/<Directory "\/usr\/local\/apache2\/htdocs">/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /usr/local/apache2/conf/httpd.conf