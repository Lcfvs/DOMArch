# <a name="title">DOMArch</a>


A PHP DOM micro-framework, based on [PHPDOM](https://github.com/Lcfvs/PHPDOM) and inspired on the MVC paradigm.

## <a name="summary">Summary</a>
* [Installation](./installation/readme.md#title)
* [Reference](./reference/readme.md#title)
* [Tutorials](./tutorials/readme.md#title)
* [Licenses](#licenses)

## <a name="installation">Installation :</a>

- Put all files, directly on your `/www`
- Enable the Apache Rewrite module
- Enable the Apache SetEnvIf module
- Go to [http://127.0.0.1] (http://127.0.0.1)
- Enjoy ;)

(No virtualhosts needed, the .htaccess detects the host and redirects the requests to the directory with the same name)


## <a name="rewrite-or-setenvif-module-is-disabled">Rewrite or SetEnvIf module is disabled ?</a>

No problem, got a fallback.

- Put all files, directly on your `/www`
- Rename the `.htaccess` to `.htaccess.bak`
- And prefix all your urls by `?/`
    - Like [http://127.0.0.1/?/css/style.css](http://127.0.0.1/?/css/style.css)
    - Like [http://127.0.0.1/?/class_name/action?param=value](http://127.0.0.1/?/class_name/action?param=value)
- Go to [http://127.0.0.1] (http://127.0.0.1)
- Enjoy ;)

## <a name="license">License :</a>

This project is bi-MIT licensed.

Copyright © 2008 - 2009 TJ Holowaychuk <tj@vision-media.ca><br />
Copyright 2015 Lcf.vs