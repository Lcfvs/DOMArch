# <a name="title">DOMArch</a>

How to route ?

## <a name="summary">Summary</a>
* [How to route ?](./how-to-route.md#title)
* [Create a webpage](./create-a-webpage.md#title)
* [](./.md#title)

[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)


## <a name="how-it-matches-the-host-and-directory">How it matches the host and directory ?</a>

On each user request, the `.htaccess` (or `DOMArch/index.php`) detects the host and if a directory has the same name and contains a `./system/index.php`, it redirects the query to that file.

Then each server known host (in the OS `hosts` file) can redirect to its own directory.