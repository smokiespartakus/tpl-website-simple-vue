import {ajax} from '/_js/managers/AjaxManager.js';
import {numberFormat} from '/_js/helpers/numbers.js?v=1';

export default {
	components: {
		Heading: mixImportGlobal('elements/Heading.js'),
		InputText: mixImportGlobal('elements/form/InputText.js'),
		InputFile: mixImportGlobal('elements/form/InputFile.js'),
		Btn: mixImportGlobal('elements/Btn.js'),
		Link: mixImportGlobal('elements/Link.js'),
		Top: mixImport('partials/Top.js'),
	},
	name: 'App',
	template: `
		<div class="bg-primary text-white min-h-screen w-full p-4">
			<Top />
			<Heading h="1">_TEMPLATE TPL SITE</Heading>
			<div>
			123
			</div>
		</div>
		`,
	setup() {
		return {};
	},
	data() {
		return {
			loading: false,
		};
	},
	props: {},
	methods: {
		async load() {
			this.loading = true;
			const response = await ajax.get('test');
			this.loading = false;
		},
	},
	mounted() {
		this.load();
	},
};
