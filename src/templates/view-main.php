<?php
if (!is_file(realpath(public_path('_sub', SUB_NAME, 'js', 'components', 'App.js')))) {
	echo 'App.js not found. Please run the symlink command: php symlink.php ' . SUB_NAME;
	exit(1);
}
?>
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
<!--	<link rel="stylesheet" href="/_css/fontawesome.v5.6.3.all.css" />-->
	<link rel="stylesheet" href="/_css/fontawesome.free.v6.7.2.all.min.css" />

	<link rel="stylesheet" href="<?php mix('/css/app.css')?>?v=<?php echo VERSION?>" />
	<style type="text/tailwindcss">
		<?php
		if (is_file(local_public_path('css', 'tailwind.css')))
			include local_public_path('css', 'tailwind.css');
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
		window.__LOCAL_FOLDER__ = '<?php echo SUB_NAME ?>';
		function mix(p) {
			return `/_sub/${window.__LOCAL_FOLDER__}/js/components/${p}?v=${window.__VERSION__}`;
		}
		function mixImport(p) {
			return Vue.defineAsyncComponent(() => import(mix(p)));
		}
		function mixGlobal(p) {
			return `/_js/components/${p}?v=${window.__VERSION_GLOBAL__}`;
		}
		function mixImportGlobal(p) {
			return Vue.defineAsyncComponent(() => import(mixGlobal(p)));
		}
	</script>
</head>
<body>
<div id="app" class="" v-cloak></div>
<script type="module">
	import App from '<?php mixv('/js/components/App.js') ?>';
	const app = Vue.createApp(App);
	app.mount('#app');
</script>
</body>
</html>
