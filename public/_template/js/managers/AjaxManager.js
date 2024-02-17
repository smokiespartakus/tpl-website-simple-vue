// const axios = require('axios');
import AjaxRequest from './AjaxRequest.js';

/*
 * Usage:
 * import {ajax} from '../managers/AjaxManager';
 * Initialize (e.g. on App.vue):
 * ajax
 * 		.addOnFail((err, response) => {...})
 * 		.addOnSuccess((response) => {...})
 * 		.addOnLoading((loading) => {...})
 * 		.setConfig({debug: true});
 *
 * // Simple usage
 * ajax.get('path', {queryValues});
 * ajax.post('path', {postData});
 *
 *
 * // All the options can be chained
 * // Triggering loading added on manager
 * ajax.loading().get('path', {queryValues});
 *
 * // Triggering custom loading
 * ajax.loading((loading) => { loading updated }).post('path', {postData});
 *
 * // Silent requests
 * ajax.silent().post('path', {postData});
 *
 * // File uploads
 * ajax.files({file: file}).post('path', {postData});
 */

class AjaxManager {

	/**
	 * @type {AjaxManager}
	 */
	static _instance = null;

	/**
	 * @returns {AjaxManager}
	 */
	static instance() {
		if (!this._instance) this._instance = new this();
		return this._instance;
	}

	onFailCallbacks = [];
	onSuccessCallbacks = [];
	onLoadingUpdateCallbacks= [];

	config = {
		debug: false,
	};

	/**
	 * Set config values.
	 * @param {{}} cfg
	 * @returns {AjaxManager}
	 */
	setConfig(cfg) {
		this.config = {...this.config, ...cfg};
		return this;
	}


	/**
	 * Add a function that will be called on every fail.
	 * @param fn
	 * @return {AjaxManager}
	 */
	addOnFail(fn) {
		this.onFailCallbacks.push(fn);
		return this;
	}

	/**
	 * Add a function that will be called on every success.
	 * @param fn
	 * @return {AjaxManager}
	 */
	addOnSuccess(fn) {
		this.onSuccessCallbacks.push(fn);
		return this;
	}

	/**
	 * Add a function that will be called on every loading update if enabled on request.
	 * @param onLoading
	 * @returns {AjaxManager}
	 */
	addOnLoading(onLoading) {
		this.onLoadingUpdateCallbacks.push(onLoading);
		return this;
	}

	/**
	 *
	 * @return {AxiosInstance}
	 */
	getAxios() {
		const headers = {};
		return axios.create({
			baseURL: `/${window.__LOCAL_FOLDER__}/ajax/`,
			timeout: 30000,
			headers: headers,
		})
	}


	/**
	 * Create a new AjaxRequest
	 * @returns {AjaxRequest}
	 */
	create() {
		return new AjaxRequest(
			{
				axios: this.getAxios(),
				onResponse: (request) => {
					return this.onResponse(request);
				},
				onLoadingUpdate: (loading) => {
					this.onLoadingUpdateCallbacks.forEach(fn => {
						try {
							fn(loading);
						} catch (e) {
							this.error('onLoadingUpdate error', loading, e);
						}
					});
				},
				log: (...args) => {
					this.log(...args);
				},
			}
		);
	}

	/**
	 * Shortcut for create().silent().
	 * Silent requests will not trigger loading and error callbacks
	 * @returns {AjaxRequest}
	 */
	silent() {
		return this.create().silent();
	}

	/**
	 * Shortcut for create().files().
	 * Add files to request. It will change it to multipart/form-data
	 * @param files
	 * @returns {AjaxRequest}
	 */
	files(files) {
		return this.create().files(files);
	}

	/**
	 * Shortcut for create().loading()
	 * @param {function|null} loading custom loading function. Otherwise the default loading function will be used.
	 * @returns {AjaxRequest}
	 */
	loading(loading = null) {
		return this.create().loading(loading);
	}

	/**
	 * Shortcut for create().get()
	 * @param path
	 * @param queryValues
	 * @returns {Promise<*>}
	 */
	async get(path, queryValues = null) {
		return await this.create().get(path, queryValues);
	}

	/**
	 * Shortcut for create().post()
	 * @param path
	 * @param postData
	 * @returns {Promise<*>}
	 */
	async post(path, postData) {
		return await this.create().post(path, postData);
	}


	/**
	 *
	 * @param {AjaxRequest} request
	 */
	onResponse(request) {
		const response = request.getResponse();
		const errorMsg = request.getErrorMsg();
		const errorType = request.getErrorType();
		const data = response?.data;
		if (response?.status === 200 || response?.status === 422) {
			this.log('response success', data, request.getMethod(), request.isSilent());
			if (!request.isSilent()) {
				this.onSuccessCallbacks.forEach(fn => {
					try {
						fn(data);
					} catch (e) {
						this.error('onSuccessCallback error', e);
					}
				});
			}
			return data || null;
		} else if (!request.isSilent()) {
			this.onFail(errorType || AjaxRequest.ErrorTypes.RESPONSE_CODE_ERROR, errorMsg || ('response status=' + response?.status || 'x'), response);
		}
		return null;
	}


	/**
	 * @param {string} errType ErrorType
	 * @param {string} err
	 * @param {AxiosResponse<any>} response
	 */
	onFail(errType, err, response) {
		this.onFailCallbacks.forEach(fn => {
			try {
				fn(err, response);
			} catch (e) {
				this.error('onFailCallback error', e);
			}
		});
		this.error('request fail: ' + err);
		// throw new Error(err);
	}

	log(...args) {
		if (this.config?.debug) console.log(this.constructor.name, ...args);
	}

	error(...args) {
		if (this.config?.debug) console.error(this.constructor.name, ...args);
	}

	destroy(){
		this._instance = null;
	}

}

export const ajax = AjaxManager.instance();
