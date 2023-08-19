# SmartVideo for Woocommerce

A WooCommmerce Extension inspired by [Create Woo Extension](https://github.com/woocommerce/woocommerce/blob/trunk/packages/js/create-woo-extension/README.md).

## Getting Started

### WARNING

This code base requires multiple older versions of node/npm/pnpm. The mandatory versions are set by .tool-versions
to be used with ASDF.

Despite this, there remains an unresolvable (afaik) dep conflict for eslint between divi-builder and the root.
This is bypassed in the build-deploy-plugin.sh script.

### Prerequisites

-   [NPM](https://www.npmjs.com/)
-   [Composer](https://getcomposer.org/download/)
-   [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)

### Installation and Build

```
pnpm install
pnpm run build
wp-env start
```

Visit the added page at http://localhost:8888/wp-admin/admin.php?page=wc-admin&path=%2Fexample.

## Packaging the zip

To build the zip file, run:

```
build-plugin-zip.sh
```

The default `plugin-zip` command isn't very bright. The list of files zipped is defined in `files` in `package.json`.


### Credentials

The local environment will be available at http://localhost:8888 (Username: admin, Password: password).

The database credentials are: user root, password password. 
