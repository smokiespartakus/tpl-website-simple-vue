import {ajax} from '../managers/AjaxManager.js';
import {numberFormat} from '../helpers/numbers.js?v=1';
export default {
	components: {
		Heading: mixImportGlobal('elements/Heading.js'),
		InputText: mixImportGlobal('elements/form/InputText.js'),
		InputFile: mixImportGlobal('elements/form/InputFile.js'),
		Btn: mixImportGlobal('elements/Btn.js'),
		Link: mixImportGlobal('elements/Link.js'),
		Top: mixImportGlobal('partials/Top.js'),
	},
	name: 'App',
	template: `
		<div class="bg-primary text-white min-h-screen w-full p-4">
			<Top />
			<Heading h="1">TEMPLATE</Heading>
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
			// const response = await ajax.get('get_data');
			this.loading = false;
		},
	},
	mounted() {
		this.load();
	},
}
