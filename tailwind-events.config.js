/**
 * This is the Tailwind CSS configuration file for the Hyde Events Module package.
 *
 * @package Melasistema\HydeEventsModule
 * @author  Luca Visciola
 * @copyright 2024 Luca Visciola
 * @license MIT License
 *
 * To include this configuration in your project's `tailwind.config.js`,
 * you need to require and merge it with your existing configuration.
 *
 * Example usage in `tailwind.config.js`:
 *
 * const hydeEventsConfig = require('./tailwind-events.config.js');
 *
 * module.exports = {
 *     darkMode: 'class',
 *     content: [
 *         ...hydeEventsConfig.content, // Merge Hyde Events Module content paths
 *     ],
 *     theme: {
 *         extend: {
 *             ...hydeEventsConfig.theme.extend, // Merge the extend
 *        },
 *     },
 * };
**/

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/melasistema/hyde-events-module/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            minWidth: {
                '1/5': '10rem',
            },
        },
    },
};
