import {ajax} from '../managers/AjaxManager.js';
import {numberFormat} from '../helpers/numbers.js?v=1';
export default {
	components: {
		Heading: mixImport('elements/Heading.js'),
		InputText: mixImport('elements/form/InputText.js'),
		InputFile: mixImport('elements/form/InputFile.js'),
		Btn: mixImport('elements/Btn.js'),
		Link: mixImport('elements/Link.js'),
		Top: mixImport('partials/Top.js'),
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
