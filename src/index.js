/**
 * External dependencies
 */

import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { 
	Button, 
	Card, 
	CardHeader, 
	CardBody, 
	CardFooter,
	CardMedia, 
	CardDivider, 
	CheckboxControl,
	ColorPicker,
	__experimentalDivider as Divider,
	Dropdown, 
	ExternalLink, 
	Flex, 
	FlexBlock, 
	FlexItem,
	__experimentalHeading as Heading,
	__experimentalInputControl as InputControl,
	Panel,
	PanelBody,
	PanelRow,
	ResponsiveWrapper,
	SelectControl,
	Spacer,
	TabPanel,
	__experimentalText as Text,
	ToggleControl,
	Tooltip,
	__experimentalVStack as VStack
 } from '@wordpress/components';
import * as Woo from '@woocommerce/components';
import { Fragment } from '@wordpress/element';

import { partial } from 'lodash';

import { OPTIONS_STORE_NAME } from '@woocommerce/data';
import { useSelect, useDispatch } from '@wordpress/data';

import './index.scss';

// Utility fns
const boolify = val => val === "on" ? true : false;
const onoffify = val => {
	if(typeof val === "boolean") {
		return val ? "on" : "off"
	} 
	return val;
};

const optNames = [
	"swarmify_status",
	"swarmify_cdn_key",
	"swarmify_toggle_youtube",
	"swarmify_toggle_youtube_cc",
	"swarmify_toggle_layout",
	"swarmify_toggle_bgvideo",
	"swarmify_toggle_uploadacceleration",
	"swarmify_theme_button",
	"swarmify_toggle_uploadacceleration",
	"swarmify_theme_primarycolor",
	"swarmify_watermark",
	"swarmify_ads_vasturl"
];


const Welcome = ({jumpToSetup}) => (
	<Card>	
		<CardBody>
			<h2>Welcome to SmartVideo! 👋</h2>
			<p className="paragraph">We're excited to start powering your site's video experience. After just a few minutes of setup, your site will have a fast, clean, professional video experience that your visitors will love.</p>
		</CardBody>
		<CardDivider/>
		<CardBody>
			<Flex direction="column">
				<FlexItem>
					<h2>If you already have a SmartVideo account, click the button below:</h2>
				</FlexItem>
				<FlexItem>
					<Button
						className="swarmify-button"
						variant="primary"
						onClick={jumpToSetup}>Setup
					</Button>
				</FlexItem>
			</Flex>
		</CardBody>
	</Card>
)

const Setup = ({cdnKey, jumpToUsage}) => {
	const { updateOptions } = useDispatch(OPTIONS_STORE_NAME);

	return <Fragment>
			{/* <VStack spacing={8}> */}
				{/* <FlexBlock>
					<h2>Let's get you set up! 👍</h2>
				</FlexBlock> */}
				<Card>
					<CardHeader><h2>Your CDN Key</h2></CardHeader>
					<CardBody>
						<div>1. Visit <ExternalLink href="https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=49">dash.swarmify.com</ExternalLink></div>
					</CardBody>
					<CardDivider/>
					<CardBody>
						<VStack>
							<div>2. Copy your Swarm CDN Key to your clipboard like so:</div>
							<CardMedia>
							{/* <ResponsiveWrapper> */}
								<img src={smartvideoPlugin.assetUrl + '/admin/images/screen1.gif'} alt=""/>
							{/* </ResponsiveWrapper> */}
							</CardMedia>
						</VStack>
					</CardBody>
					<CardDivider/>
					<CardBody>
						<Flex direction="column">
							<FlexItem>3. Paste your <b>Swarm CDN Key</b> into the field below:</FlexItem>
							<FlexItem>
								<InputControl
									value={cdnKey}
									onChange={ value => updateOptions({swarmify_cdn_key: value}) }
									placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
								</InputControl>
							</FlexItem>
						</Flex>
					</CardBody>
					<CardDivider/>
					<CardBody>
						<Flex direction="column">
							<FlexItem>4. Click the button below:</FlexItem>
							<FlexItem>
								<Button
									className="swarmify-button"
									variant="primary"
									onClick={ () => updateOptions({swarmify_status: "on"}) }>Enable SmartVideo</Button>
							</FlexItem>
						</Flex>
					</CardBody>
					<CardDivider/>
					<CardBody>
						<Flex direction="column">
							<FlexItem>5. Now that everything's enabled, visit the <b>Usage</b> tab to learn how to add SmartVideos, or check out the Settings tab to customize how SmartVideo works.</FlexItem>
							{/* <FlexItem>
								<Button
									className="swarmify-button"
									variant="primary"
									onClick={ jumpToUsage }>Usage</Button>
							</FlexItem> */}
						</Flex>
					</CardBody>
				</Card>
			{/* </VStack> */}
			</Fragment>;
};

const Usage = () => (
	<Card>	
		<CardHeader>
			<h2>How do I add a SmartVideo to my website?</h2>
		</CardHeader>
		<CardBody>
			<VStack spacing={8} alignment="left" expanded={false}>
				<div className="setup-paragraph">After enabling SmartVideo, it will begin scanning your site for YouTube and Vimeo videos.</div>
				<div className="setup-paragraph"><b>If you have YouTube or Vimeo videos on your site</b>, they will be converted to SmartVideo and be displayed in a clean, fast-loading player automatically, requiring no extra work on your part.</div>
				<div className="setup-paragraph"><b>If you want to add a video to your site directly</b>, simply use our included SmartVideo block. After enabling SmartVideo, this block will be visible in your page editor <i>(current supported editors: Classic WordPress Editor, Gutenberg, Beaver Builder, Divi, and Elementor)</i>.</div>
				<CardMedia>
					<img src={smartvideoPlugin.assetUrl + '/admin/images/widgetdemo.gif'} alt=""/>
				</CardMedia>
				<div className="setup-paragraph">When a page with a video loads for the first time, SmartVideo fetches that video, encodes it, and stores it on our network. Depending on the resolution of the video file, <b>a video typically takes one to two times the length of the video to process</b> <i>(a 10-minute video should take 10-20 minutes)</i>.</div>
				<div className="setup-paragraph">You will know that a video has been fully converted by SmartVideo when, while hovering over the <i>Video Acceleration</i> icon on the player, the popup box says <b>Video Acceleration: On</b></div>
				<CardMedia>
					<img src={smartvideoPlugin.assetUrl + '/admin/images/accelon.gif'} alt=""/>
				</CardMedia>
				<div className="setup-paragraph">If the popup box says <b>Video Acceleration: Off</b>, the video is still being processed.</div>
				<div className="setup-paragraph">After the conversion process is complete, the video is hosted on our global delivery network and served via our accelerated playback technology. This means you can keep uploading your videos to YouTube and placing them on your site, as SmartVideo will continuously look for new videos and convert them automatically.</div>
			</VStack>
		</CardBody>
		<CardBody>	
			<p><b>If you have questions</b>, take a look at the Frequently Asked Questions collection in our Help Center.</p>
			<Button className="swarmify-button" variant="primary" href="https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=50" target="_blank">FAQs</Button>
		</CardBody>
		<CardDivider/>
		<CardBody>
			<p><b>If you are not using a supported builder or editor</b>, YouTube and Vimeo videos should be auto-converted just fine. However, if you want to add a SmartVideo directly to your site, you'll have to make use of a SmartVideo tag. Click the button below to learn about SmartVideo tags.</p>
			<Button className="swarmify-button" variant="primary" href="https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=51" target="_blank">SmartVideo tags</Button>
		</CardBody>
	</Card>
);

const StatusToggle = ({opts, updateToggleOption}) => {
	const cdnKeyValid = opts.swarmify_cdn_key !== "";
	const label = cdnKeyValid ? "Enable SmartVideo" : "You must enter a valid Swarm CDN Key before you can enable SmartVideo. Click on the Setup tab.";

	return <ToggleControl
			className="settings-label"
			label={label}
			checked={ boolify(opts.swarmify_status) }
			disabled={!cdnKeyValid}
			onChange={ val => updateToggleOption("swarmify_status", val) }/>;
};

const Settings = ({opts}) => {

	const { updateOptions } = useDispatch(OPTIONS_STORE_NAME);
	const updateToggleOption = (name, val) => {
		const opts = {};
		opts[name] = onoffify(val);

		return updateOptions(opts);
	};

	return <Fragment>
			<Card>
				<CardBody>
					<VStack spacing={4}>
						<h2>Toggle SmartVideo on/off</h2>
						<StatusToggle opts={opts} updateToggleOption={updateToggleOption} />
					</VStack>
				</CardBody>
				
				<CardBody>
					<Card>
						<CardHeader isShady={true}>Basic Options</CardHeader>
						<CardBody>
							<VStack spacing={4}>
								<div className="option-text">Toggle YouTube & Vimeo auto-conversions on or off</div>
								<CheckboxControl
									label="Auto-convert YouTube and Vimeo videos"
									checked={ boolify(opts.swarmify_toggle_youtube) }
									onChange={ val => updateToggleOption("swarmify_toggle_youtube", val) }/>
								<CardDivider/>
								<div className="option-text">Display closed captions when available from YouTube sources</div>
								<CheckboxControl
									label="Import and display closed captions from YouTube sources"
									checked={ boolify(opts.swarmify_toggle_youtube_cc) }
									onChange={ val => updateToggleOption("swarmify_toggle_youtube_cc", val) }/>
								<CardDivider/>
								<div className="option-text">Optimize background videos and existing videos</div>
								<CheckboxControl
									label="Optimize videos that are currently on your website or in the background of your theme. May conflict with some layouts."
									checked={ boolify(opts.swarmify_toggle_bgvideo) }
									onChange={ val => updateToggleOption("swarmify_toggle_bgvideo", val) }/>
								<CardDivider/>
								<div className="option-text">Change the shape of the play button</div>
								<SelectControl
									value={opts.swarmify_theme_button}
									onChange={ val => updateToggleOption("swarmify_theme_button", val) }>
									<option value="default">Default</option>
									<option value="rectangle">Rectangle</option>
									<option value="circle">Circle</option>
								</SelectControl>
								<CardDivider/>
								<div className="option-text">Choose a color to match the video player components with your website colors</div>
								<ColorPicker
									color={opts.swarmify_theme_primarycolor}
									copyFormat="hex"
									defaultValue="#ffde17"
									onChange={ val => updateToggleOption("swarmify_theme_primarycolor", val) }
								/>
							</VStack>
						</CardBody>	
					</Card>
				</CardBody>

				<CardBody>
					<Panel>
						<PanelBody title="Advanced Options" initialOpen={false}>
							<PanelRow>
								<VStack spacing={4} style={{margin: "15px 0"}}>
									<div className="option-text">Toggle alternate layout method</div>
									<CheckboxControl 
										label="Use alternate layout method (if you are experiencing odd video sizing or full-screen issues, try this)"
										checked={ boolify(opts.swarmify_toggle_layout) }
										onChange={ val => updateToggleOption("swarmify_toggle_layout", val) }/>
									<CardDivider/>

									<div className="option-text">Toggle upload acceleration</div>
									<CheckboxControl 
										label="Enable upload acceleration (if you have trouble with uploads, try turning this off)"
										checked={ boolify(opts.swarmify_toggle_uploadacceleration) }
										onChange={ val => updateToggleOption("swarmify_toggle_uploadacceleration", val) }/>
									<CardDivider/>

									<div className="option-text">Set a watermark (Pro Plan Only)</div>
									<div>Set an image/logo to watermark on the video player</div>
									<Woo.ImageUpload 
										image={ opts.swarmify_watermark } 
										onChange={ newImage => updateOptions({swarmify_watermark: newImage}) } />
									<CardDivider/>

									<div className="option-text">Set VAST Ad URL (Pro Plan Only)</div>
									<div>
										<InputControl
											value={opts.swarmify_ads_vasturl}
											type='url'
											onChange={ val => updateToggleOption("swarmify_ads_vasturl", val) }
											placeholder="https://example.com">
										</InputControl>
									</div>
									<div style={{fontSize: "smaller"}}>Set the VAST URL from your ad management platform (Adsense for Video, DFP, SpotX, etc.)</div>
								</VStack>
							</PanelRow>
						</PanelBody>
					</Panel>
				</CardBody>
			</Card>
		</Fragment>
};

const SignupFooter = () => (
	<footer>
			<Card>
				<CardBody>
					<h2>If you do not have a SmartVideo account yet, click the button below and create an account:</h2>
					<p className="paragraph">Every account comes with a free trial. Once you create an account, return here and click the <b>Setup</b> tab.</p>
					<Button className="swarmify-button" variant="primary" href="https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=46" target="_blank">Create an account</Button>
				</CardBody>
				<CardFooter justify="flex-end">
					<p className="copyright">SmartVideo Version {smartvideoPlugin?.version ?? "1.0.0" } powered by <a target="_blank" href="https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=48">Swarmify</a></p>
				</CardFooter>
			</Card>
		</footer>
);

const AdminHeader = ({status, cdnKey}) => {
	const smartVideoOn = boolify(status) && cdnKey !== "";

	const {str, color} = smartVideoOn ? {str: "ON", color: "#85E996"} : {str: "OFF", color: "#F45052"};

	return <header>
		<Flex direction="row" justify="space-between">
			<img className="img-responsive" src={smartvideoPlugin.assetUrl + '/admin/images/smartvideo_logo.png'} alt="SmartVideo header"/>
			<div className="swarmify-status">SmartVideo: <span style={{color}}>{ str }</span></div>
		</Flex>
	</header>
};

const SmartVideoAdmin = () => {
	const swarmifyOpts = useSelect( select => {
		const getOption = select( OPTIONS_STORE_NAME ).getOption;		

		return optNames.reduce((opts, optName) => {
			opts[optName] = getOption(optName);
			return opts;
		}, {});
	});

	// console.log("swarmifyOpts", swarmifyOpts);

	// the TabPanel offers no easy way to do this, so we have to hack it
	const jumpToTab = (tabClass) => {
		document.getElementsByClassName(tabClass)?.[0]?.click();

		// const tab = document.getElementsByClassName(tabClass)?.[0]?.click();
		// if (tab) {
		// 	tab.click();
		// 	// tab.scrollIntoView();
		// 	document.documentElement.scrollTop = 0;
		// 	document.body.scrollTop = 0;
		// }
	};

	return <section id="smartvideo-admin">
		<VStack spacing={8}>
			<AdminHeader status={ swarmifyOpts.swarmify_status } cdnKey={ swarmifyOpts.swarmify_cdn_key }/>
			<TabPanel
				initialTabName="welcome"
				onSelect={function noRefCheck(){}}
				activeClass="is-active"
				className="swarmify-tab-panel"
				tabs={[
					{
						name: 'welcome',
						title: __('Welcome', 'swarmify'),
						className: 'swarmify-tab swarmify-tab-welcome'
					},
					{
						name: 'setup',
						title: __('Setup', 'swarmify'),
						className: 'swarmify-tab swarmify-tab-setup',
					},
					{
						name: 'usage',
						title: __('Usage', 'swarmify'),
						className: 'swarmify-tab swarmify-tab-usage',
					},
					{
						name: 'settings',
						title: __('Settings', 'swarmify'),
						className: 'swarmify-tab swarmify-tab-settings'
					}
				]}>
				{
					activeTab => {
						switch (activeTab.name) {
							case 'welcome':
								return <Welcome jumpToSetup={ partial(jumpToTab, "swarmify-tab-setup") }/>;
							case 'setup':
								return <Setup cdnKey={swarmifyOpts.swarmify_cdn_key} jumpToUsage={ partial(jumpToTab, "swarmify-tab-usage") }/>;
							case 'usage':
								return <Usage/>;
							case 'settings':
								return <Settings opts={swarmifyOpts}/>;
							default:
								throw new Error('Unknown tab: ' + activeTab);
						}
					}
				}
			</TabPanel>
			
			<SignupFooter/>
		</VStack>
	</section>
};

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
