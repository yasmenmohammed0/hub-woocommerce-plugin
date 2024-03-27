/**
 * External dependencies
 */
import { addFilter,doAction ,} from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { Dropdown } from '@wordpress/components';
import * as Woo from '@woocommerce/components';
import { Fragment } from '@wordpress/element';
import {actions } from '@wordpress/hooks';
import { useState } from'react';

/**
 * Internal dependencies
 */
import './index.scss';

const MyExamplePage = () => {

	const [ consumerKey, setConsumerKey ] = useState([]);
	const [ consumerSecret, setConsumerSecret ] = useState([]);


	return(
	<Fragment>



		<Woo.Section component="article">
		<Woo.SectionHeader title={__('Welcome to Hub!!', 'hub')} />
			Hub is a business communication app that integrates and streamlines communication with stores and their customers. It provides tools for customer support, marketing, sales and more.
		</Woo.Section>

		
	</Fragment>
);
}
addFilter('woocommerce_admin_pages_list', 'hub', (pages) => {
	pages.push({
		container: MyExamplePage,
		path: '/hub',
		breadcrumbs: [__('Hub', 'hub')],
		navArgs: {
			id: 'hub',
		},
	});

	return pages;
});
