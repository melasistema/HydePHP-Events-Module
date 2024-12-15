# HydePHP Events Module

A powerful and customizable events module for HydePHP

HydePHP Events Module extends the capabilities of HydePHP, an elegant static site generator, by adding robust event management functionality. This package enables developers to easily create, paginate, and manage event pages within their HydePHP projects.

---

## Features

- **Event Management**: Create and manage events effortlessly.
- **Hyde Pagination Support**: Automatically paginate your event listings.
- **TailwindCSS Integration**: Publish and extend custom TailwindCSS configurations for event styling.
- **Seamless Configuration**: Publish and manage a dedicated configuration file for the events module.

---

## Requirements

- **PHP**: ^8.0
- **HydePHP**: ^1.7

---

## Installation

Install the HydePHP Events Module via Composer:

```bash
composer require melasistema/hyde-events-module
```

### Step 1: Publish Configuration Files

After installation, publish the configuration file and TailwindCSS configuration using the following commands:

```bash
php hyde vendor:publish --tag=hyde-events-config
php hyde vendor:publish --tag=tailwind-events-config
```

### Step 2: Update Your Tailwind Configuration

Merge the contents of the published `tailwind-events.config.js` file with your project's default Tailwind configuration. This ensures your event pages inherit custom styles while maintaining the consistency of your site's design.

```js
const defaultTheme = require('tailwindcss/defaultTheme');
const hydeEventsConfig = require('./tailwind-events.config.js');

module.exports = {
    darkMode: 'class',
    content: [
        './_pages/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './vendor/hyde/framework/resources/views/**/*.blade.php',
        ...hydeEventsConfig.content, // Merge  Hyde Events Module content paths
    ],

    theme: {
        extend: {
            ...hydeEventsConfig.theme.extend, // Merge the extend section from the Hyde Events Module config
            // Default and yours custom theme settings
        },
    },

    plugins: [
        // Default and yours custom theme settings
    ],
};
```
---

## Publishing and Customizing Views

The HydePHP Events Module comes with pre-designed Blade templates for displaying events, event listings, and event details. If you want to customize the look and feel of these pages, you can publish the views to your project and modify them as needed.

### Step 1: Publish Views

To publish the views, run the following Artisan command:

```bash
php hyde vendor:publish --tag=hyde-events-views
```

This will copy the views from the package into your project\
's resources/views/vendor/hyde-events directory.

### Step 2: Customize the Views

Once the views are published, you can freely edit them in the <code>resources/views/vendor/hyde-events</code> directory. For example, if you want to customize the layout or design of the event pages, you can modify the relevant Blade files here.

<code>resources/views/vendor/hyde-events/event-post-feed.blade.php</code>: Customize the event listing page.
<code>resources/views/vendor/hyde-events/components/event/article.blade.php</code>: Modify the individual event detail page.

By publishing the views, you gain full control over how events are presented in your application, making it easy to adapt the module to your specific design needs.

---

## Usage

### Create Events

Leverage the included artisan commands to create new events:

```bash
php hyde make:event "Your Event Name"
```

This will generate an event Markdown file with the necessary front matter, ready to be customized.

### Generate Event Homepage

Publish a pre-designed homepage for your events:

```bash
php artisan publish:event-homepage
```

Customize the homepage as needed by editing the generated files in your project.

### Configuration

The configuration file `config/hyde-events.php` allows you to customize various aspects of the module, including:

- **Pagination Settings**: Define the number of events displayed per page.

---

## Development and Contributions

Contributions are welcome! If you encounter any issues or have ideas for new features, feel free to submit an issue or open a pull request on the [GitHub repository](https://github.com/melasistema/hyde-events-module).

### Local Development

Clone the repository and install dependencies:

```bash
git clone https://github.com/melasistema/hyde-events-module.git
cd hyde-events-module
composer install
```

---

## Credits

- **Author**: Luca Visciola ([info@melasistema.com](mailto:info@melasistema.com))
- **Inspired by HydePHP**: Created by [Caen De Silva](https://github.com/caendesilva) ([HydePHP GitHub](https://github.com/hydephp/hyde))

---

## License

This package is licensed under the MIT License. See the [LICENSE](./LICENSE.md) file for more details.

---

**HydePHP Events Module:** Bringing event management to the elegant world of HydePHP.