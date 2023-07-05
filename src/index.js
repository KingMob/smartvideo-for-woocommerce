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
				title={__('Search', 'smartvideo-woocommerce-plugin')}
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
				title={__('Dropdown', 'smartvideo-woocommerce-plugin')}
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
					'smartvideo-woocommerce-plugin'
				)}
			/>
			<Woo.Pill className={'pill'}>
				{__('Pill Shape Container', 'smartvideo-woocommerce-plugin')}
			</Woo.Pill>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Spinner', 'smartvideo-woocommerce-plugin')}
			/>
			<Woo.H>I am a spinner!</Woo.H>
			<Woo.Spinner />
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Datepicker', 'smartvideo-woocommerce-plugin')}
			/>
			<Woo.DatePicker
				text={__('I am a datepicker!', 'smartvideo-woocommerce-plugin')}
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
					'Smartvideo Woocommerce Plugin',
					'smartvideo-woocommerce-plugin'
				),
			],
			navArgs: {
				id: 'smartvideo_woocommerce_plugin',
			},
		});

		return pages;
	}
);
