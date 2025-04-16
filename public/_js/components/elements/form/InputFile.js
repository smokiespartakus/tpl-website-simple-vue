export default {
	name: 'InputFile',
	template: `
		<div class="form-group">
			<label v-if="label" class="label" :for="id">{{label}}</label>
			<input 
				ref="input"
				@input="onChange"
				class="block" 
				type="file"
				:name="name"
				:id="id"
				:disabled="disabled"
				:readonly="readonly"
				:multiple="multiple"
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
			type: [String, Object, Array],
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
		multiple: {
			type: Boolean,
		},
		name: {
			type: String,
		},
		id: {
			type: String,
		},
	},
	emits: ['files'],
	components: {},
	methods: {
		onChange() {
			this.$emit('files', this.$refs.input.files);
		},
		clear() {
			this.$refs.input.value = '';
		}
	},
	mounted() {
		this.value = this.modelValue;
	},
}
