simple-media-storage
====================

Simple media-storage server


## Image rewrite rules for Apache/Nginx

When the target image does not exist. It will be rewrite to image.php, then generate the targe image automatically.

The url rule:
http://DOMAINNAME/public/attachment/200x200/imagename.jpg

Web server configuration:

* For Nginx
        
            location  /public/  {
                try_files $uri /image.php;
            }

* For Apache .htaccess under /public/ directory
        
            Options All -Indexes
            <IfModule mod_php5.c>
            php_flag engine 0
            </IfModule>
            
            AddHandler cgi-script .php .pl .py .jsp .asp .htm .shtml .sh .cgi
            Options -ExecCGI
            
            <IfModule mod_rewrite.c>
            
            ############################################
            ## enable rewrites
            
                Options +FollowSymLinks
                RewriteEngine on
            
            ############################################
            ## never rewrite for existing files
                RewriteCond %{REQUEST_FILENAME} !-f
            
            ############################################
            ## rewrite everything else to index.php
            
                RewriteRule .* ../image.php [L]
            
            </IfModule>


## Curl post images

####Api target : http://DOMAINNAME/service.php
####Parameters:
#####Response:

Check clent_examples/* for details
