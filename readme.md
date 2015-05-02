#DOMArch

A PHP DOM micro-framework, based on [PHPDOM] (https://github.com/Lcfvs/PHPDOM)<br />


## Usage :

- Put all files, directly on your /www
- Enable the Apache Rewrite module
- Enable the Apache SetEnvIf module
- Go to [http://127.0.0.1] (http://127.0.0.1)
- Enjoy ;)

(No virtualhosts needed, the .htaccess detects the host and redirects the requests to the directory with the same name)


## No server config access ?

No problem, rename the `.htaccess` to `.htaccess.bak`.

And prefix all your urls by `?/`.

Like [http://127.0.0.1/?/css/style.css](http://127.0.0.1/?/css/style.css)


## License :

This project is bi-MIT licensed.

Copyright © 2008 - 2009 TJ Holowaychuk <tj@vision-media.ca><br />
Copyright 2015 Lcf.vs