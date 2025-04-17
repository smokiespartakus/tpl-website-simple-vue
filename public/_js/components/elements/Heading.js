export default {
	name: 'Heading',
	template: `
		<h1 v-if="h==1" class="font-bold text-4xl mb-2"><slot /></h1>
		<h1 v-if="h==2" class="font-bold text-3xl mb-2"><slot /></h1>
		<h1 v-if="h==3" class="font-bold text-2xl mb-2"><slot /></h1>
		<h1 v-if="h==4" class="font-bold text-xl mb-2"><slot /></h1>
		`,
	setup() {
		return {};
	},
	data() {
		return {};
	},
	props: {
		h: {
			type: [Number, String],
			default: 1,
		},
	},
	components: {},
	methods: {},
	mounted() {
	},
	computed: {},
};
