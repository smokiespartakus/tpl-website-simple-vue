<!doctype html>
<html lang="en">
<head>
	<title><?php echo env('APP_NAME'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8" />
<meta name="version" content="<?=VERSION?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, nofollow">

<link rel="shortcut icon" href="<?php mix('favicon.png') ?>" />
<!-- font awesome -->
<link rel="stylesheet" href="/_css/fontawesome.v5.6.3.all.css" />

<link rel="stylesheet" href="<?php mix('/css/app.css')?>?v=<?php echo VERSION?>" />
<style type="text/tailwindcss">
	<?php
		include public_path('css', 'tailwind.css');
	?>
</style>
<?php if (environment('local')): ?>
	<script src="/_js/vue.3.3.11.global.js"></script>
<?php else: ?>
	<script src="/_js/vue.3.3.11.min.js"></script>
<?php endif; ?>
<script src="/_js/vue-router.4.2.5.global.js"></script>
<script src="/_js/axios.1.6.2.min.js"></script>

<script src="/_js/tailwind.3.3.5.js"></script>
<script src="<?php mixv('/js/tailwind.config.js') ?>"></script>
<script>
	window.__VERSION__ = '<?php echo VERSION ?>';
	window.__LOCAL_FOLDER__ = '';
	function mix(p) {
		return `/js/components/${p}?v=${window.__VERSION__}`;
	}
	function mixImport(p) {
		return Vue.defineAsyncComponent(() => import(mix(p)));
	}
</script>
</head>
<body>
<div id="app" class="" v-cloak></div>
<script type="module">
	import App from './js/components/App.js<?php echo '?v=' . VERSION ?>';
	const app = Vue.createApp(App);
	app.mount('#app');
</script>
</body>
</html>
