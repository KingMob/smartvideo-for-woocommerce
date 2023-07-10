/**
 * External dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { Dropdown } from '@wordpress/components';
import * as Woo from '@woocommerce/components';
import { Fragment } from '@wordpress/element';

/**
 * Internal dependencies
 */
import './index.scss';

const SmartVideoAdmin = () => (
	<Fragment>
		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Search', 'swarmify')}
			/>
			<Woo.Search
				type="products"
				placeholder="Search for something"
				selected={[]}
				onChange={(items) => setInlineSelect(items)}
				inlineTags
			/>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Dropdown', 'swarmify')}
			/>
			<Dropdown
				renderToggle={({ isOpen, onToggle }) => (
					<Woo.DropdownButton
						onClick={onToggle}
						isOpen={isOpen}
						labels={['Dropdown']}
					/>
				)}
				renderContent={() => <p>Dropdown content here</p>}
			/>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__(
					'Pill shaped container',
					'swarmify'
				)}
			/>
			<Woo.Pill className={'pill'}>
				{__('Pill Shape Container', 'swarmify')}
			</Woo.Pill>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Spinner', 'swarmify')}
			/>
			<Woo.H>I am a spinner!</Woo.H>
			<Woo.Spinner />
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Datepicker', 'swarmify')}
			/>
			<Woo.DatePicker
				text={__('I am a datepicker!', 'swarmify')}
				dateFormat={'MM/DD/YYYY'}
			/>
		</Woo.Section>
	</Fragment>
);

addFilter(
	'woocommerce_admin_pages_list',
	'smartvideo-woocommerce-plugin',
	(pages) => {
		pages.push({
			container: SmartVideoAdmin,
			path: '/smartvideo-woocommerce-plugin',
			breadcrumbs: [
				__(
					'SmartVideo for WooCommerce',
					'swarmify'
				),
			],
			navArgs: {
				id: 'SmartVideo_WooCommerce_Plugin',
			},
		});

		return pages;
	}
);
