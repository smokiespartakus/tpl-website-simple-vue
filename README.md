# Template site with simple vue 

Can contain separate subsites (folders with their own setup and public folders) and API's.

## Subsite _Template
To create a new sub-site, copy the following folders/files:
- `/sub/_template`

Copy `env.template.php` to `env.php` in new folder and update the values.

`Config` files can be added to the `/config` folder in the new folder in `sub`.

### API
If only API is needed, you can delete public folder in new sub and skip the symlink. 

`setup.php` will is included automatically. Update that to handle api.

## Vue Import
Put local components/helpers/etc in `sub/my_sub/public/js/`.

Use `mixImport` to import local components like this:
```js
components: {
	HeadingLocal: mixImport('elements/HeadingLocal.js'),
}
```

### Import global components
Use `mixImportGlobal` to import global components from `public/_js` folder.
```js
components: {
	Heading: mixImportGlobal('elements/Heading.js'),
}
```
