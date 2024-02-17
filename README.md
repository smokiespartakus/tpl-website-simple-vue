# Template site with simple vue 

Can contain separate subsites (folders with their own setup and public folders) and API's.

## Subsite _Template
To create a new sub-site, the following folders/files:
- `/sub/_template`
- `/public/_template`

Both need to have identical names. Update setup file `const` to reflect that name. 

In `/public/{folder}/index.php` update the required setup file.

Copy `env.template.php` to `env.php` and update the values.

If only API is needed, then you don't need to copy contents of the public folder. Just require the new setup file in which ever php files you create.

`Config` files can be added to the `/config` folder in the new folder in `sub`.

`index` sub is a special case. It is the root of `public`, but has an `index` folder in `sub`.
