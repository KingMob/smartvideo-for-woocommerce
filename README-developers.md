# SmartVideo

A Wordpress Extension based off [Create Woo Extension](https://github.com/woocommerce/woocommerce/blob/trunk/packages/js/create-woo-extension/README.md), but no longer using WooCommerce.

## Getting Started

### WARNING

This code base requires multiple older versions of node/npm/pnpm. The mandatory versions are set by .tool-versions
to be used with ASDF.

Despite this, there remains an unresolvable (afaik) dep conflict for eslint between divi-builder and the root.
This is bypassed in the build-plugin.sh script.

### Prerequisites

-   [ASDF](https://asdf-vm.com/)
-   [PNPM](https://pnpm.io/)
-   [Composer](https://getcomposer.org/download/)
-   Docker, or something compatible, like OrbStack
-   [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)

### Installation and Build

```
pnpm install
pnpm run build
# Start Docker
wp-env start
```

Visit the added page at http://localhost:8888/wp-admin/admin.php

## Packaging the plugin

To build everything, run:

```
build-for-deployment.sh
```


### Credentials

The local environment will be available at http://localhost:8888 (Username: admin, Password: password).

The database credentials are: user root, password password. 
