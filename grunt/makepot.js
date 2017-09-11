module.exports = {
	target: {
		options: {
			domainPath: 'languages/',
			exclude: ['vendor'],
			type: 'wp-plugin',
			potHeaders : {
				poedit: true
			}
		}
	}
};
