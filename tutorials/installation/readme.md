# <a name="title">DOMArch</a>

Installation

## <a name="summary">Summary</a>
* [Install with Apache modules](./install-with-apache-modules#title)
* [Install without Apache modules](./install-without-apache-modules#title)
* [How DOMArch matches the host and directory](how-domarch-matches-the-host-and-directory)

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


## <a name="how-domarch-matches-the-host-and-directory">How DOMArch matches the host and directory ?</a>

On each user request, the `.htaccess` (or `DOMArch/index.php`) detects the host and if a directory has the same name and contains a `./system/index.php`, it redirects the query to that file.

Then each server known host (in the OS `hosts` file) can redirect to its own directory.