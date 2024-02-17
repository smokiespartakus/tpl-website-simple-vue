export const numberFormat = (number) => {
	if (isNaN(number)) return '';
	if (typeof number !== 'number') return number;
	return number.toLocaleString('en-US', {maximumFractionDigits: 2, minimumFractionDigits: 2});
};
