let counter = 0;
const serialize = function(obj) {
	const str = [];
	for (let p in obj)
		if (obj.hasOwnProperty(p)) {
			str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
		}
	return str.join("&");
}
class AjaxRequest {
	static ErrorTypes = {
		SUCCESS_ERROR: 'success_error', // I can't seem to find a place to trigger this, without callback functions
		REQUEST_ERROR: 'request_error',
		RESPONSE_CODE_ERROR: 'reponse_code_error',
	};

	_axios = null;
	_headers = null;
	_silent = false;
	_files = null;
	_loading = false;
	_onLoadingUpdate = null;
	_onLoadingUpdateBase = null;
	_method = 'get';
	_log = null;
	_response = null;
	_errorType = null;
	_errorMsg = null;

	// On response function
	_onResponse = null;

	constructor(config) {
		this._axios = config.axios;
		this._onResponse = config.onResponse;
		this._log = config.log;
		this._onLoadingUpdateBase = config.onLoadingUpdate;
	}

	/**
	 * Silent requests will not trigger loading and error callbacks
	 * @returns {AjaxRequest}
	 */
	silent() {
		this._silent = true;
		return this;
	}

	/**
	 * Add files to request. It will change it to multipart/form-data
	 * @param files
	 * @returns {AjaxRequest}
	 */
	files(files) {
		this._files = files;
		return this;
	}

	/**
	 *
	 * @param {function|null} onLoadingUpdate custom loading function. Otherwise the default loading function will be used.
	 * @returns {AjaxRequest}
	 */
	loading(onLoadingUpdate) {
		if (onLoadingUpdate) this._onLoadingUpdate = onLoadingUpdate;
		else this._onLoadingUpdate = this._onLoadingUpdateBase;
		return this;
	}

	/**
	 * Set request method
	 * @param method
	 * @returns {AjaxRequest}
	 */
	method(method) {
		this._method = method;
		return this;
	}

	/**
	 * Add headers to request
	 * @param {{}} headers
	 * @returns {AjaxRequest}
	 */
	headers(headers) {
		this._headers = {...(this._headers || {}), ...headers};
		return this;
	}

	getMethod() {
		return this._method;
	}

	getResponse() {
		return this._response;
	}
	getErrorMsg() {
		return this._errorMsg;
	}

	getErrorType() {
		return this._errorType;
	}

	isSilent() {
		return this._silent;
	}

	isLoading() {
		return this._loading;
	}

	/**
	 * @param {string} path page/action
	 * @param {object} queryValues
	 * @param {AxiosRequetConfig|null} config
	 * @returns {Promise<unknown>}
	 */
	async get(path, queryValues = null) {
		this._log('GET', path, queryValues);
		this.method('get');
		try {
			const url = path + (queryValues ? '?' + serialize(queryValues) : '');
			this._updateLoading(true);
			this._response = await this._axios.get(url);
			this._updateLoading(false);
			return this._onResponse(this);
		} catch (e) {
			this._updateLoading(false);
			this._errorType = AjaxRequest.ErrorTypes.REQUEST_ERROR;
			this._response = e.response;
			return this._onResponse(this);
		}
	}

	/**
	 * @param {string} path
	 * @param {{}|null}postData
	 * @returns {Promise<*>}
	 */
	async post(path, postData) {
		this._log('POST', path, postData);
		this.method('post');
		try {
			if (this._files) {
				const formData = new FormData();
				for (const key in postData) {
					formData.append(key, postData[key]);
				}
				for (const key in this._files) {
					formData.append(key, this._files[key]);
				}
				this.headers({
					'Content-Type': 'multipart/form-data',
				});
				postData = formData;
			}
			this._updateLoading(true);
			this._response = await this._axios.post(path, postData);
			this._updateLoading(false);
			return this._onResponse(this);
		} catch (e) {
			this._updateLoading(false);
			this._response = e.response;
			this._errorMsg = e.message;
			this._errorType = AjaxRequest.ErrorTypes.REQUEST_ERROR;
			return this._onResponse(this);
		}
	}

	_updateLoading(loading) {
		if (!this._onLoadingUpdate) return;
		this._loading = loading;
		this._onLoadingUpdate(loading);
	}

}

export default AjaxRequest;
