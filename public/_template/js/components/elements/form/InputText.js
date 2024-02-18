export default {
	name: 'InputText',
	template: `
		<div class="form-group">
			<label v-if="label" class="label" :for="id">{{label}}</label>
			<input 
				v-model="value"
				class="form-control"
				:name="name"
				:id="id" 
				:type="type"
				:disabled="disabled"
				:readonly="readonly"
				/>
		</div>
	`,
	setup() {
		return {};
	},
	data() {
		return {
			value: '',
		};
	},
	props: {
		modelValue: {
			type: [String, Number],
		},
		label: {
			type: String,
		},
		type: {
			type: String,
			default: 'text',
		},
		disabled: {
			type: Boolean,
		},
		readonly: {
			type: Boolean,
		},
		name: {
			type: String,
		},
		id: {
			type: String,
		},
	},
	components: {},
	methods: {},
	mounted() {
		this.value = this.modelValue;
	},
	computed: {
	},
	watch: {
		value(newVal) {
			this.$emit('update:modelValue', newVal);
		},
	},
}
