=== User Photo Upload ===
Contributors: rubyvio
Donate link: https://www.rubyvio.com/donate
Tags: user profile, photo upload, avatar, customization, media uploader
Requires at least: 5.0
Tested up to: 6.2
Stable tag: 1.2.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

User Photo Upload provides an easy way for users to upload, edit, and customize their profile photos in the WordPress admin. It seamlessly integrates with the native media uploader and offers various image customization options.

== Short Description ==
An intuitive plugin to upload and customize user profile photos with preset filters and style adjustments.

== Description ==
The User Photo Upload plugin allows users to upload their own profile photo using the WordPress Media Uploader. It offers preset filters (e.g., sepia, grayscale, vintage) as well as custom adjustments for brightness, contrast, saturation, grayscale, border styling, and corner rounding. The plugin enhances the user profile pages (profile.php, user-edit.php, user-new.php) with an intuitive interface, displays the uploaded photo as the user’s avatar with custom CSS filters, and adds a custom column in the admin users list for quick identification.

== Features ==
* **Frontend Upload:** Users can upload their own profile photo using the WordPress Media Uploader.
* **Editing & Customization:** Offers preset filters and custom adjustments (brightness, contrast, saturation, grayscale, border styling, corner rounding) for personalized profile photos.
* **Admin Integration:**
  * Adds a custom settings page under the WordPress Settings menu for configuring button texts and plugin options.
  * Enhances user profile pages with an intuitive interface for managing profile photos.
  * Displays the uploaded photo as the user’s avatar with applied CSS filters.
* **Custom Avatar:** Replaces the default avatar with the uploaded, styled image.
* **Admin Users List Enhancement:** Adds a dedicated column to the users list table to display profile photos.

== Installation ==
1. **Upload Plugin Files:**
   Upload the entire plugin folder to the `/wp-content/plugins/` directory.
2. **Activate Plugin:**
   Activate the plugin through the WordPress Plugins menu.
3. **Folder Structure Creation:**
   Upon activation, the plugin automatically creates the necessary CSS and JS folders (if they do not exist) in the plugin directory.

== Setup & Configuration ==
**Localization:**  
The plugin loads its text domain (`user-photo-upload`) to support translations. All translatable strings are properly wrapped in internationalization functions.

**Plugin Settings:**  
A dedicated settings page is added under **Settings → User Photo Upload**, allowing administrators to customize:
* **Upload Button Text:** Text for the button used to upload the profile photo.
* **Remove Button Text:** Text for the button that removes the profile photo.

**Enqueue Scripts & Styles:**  
The plugin enqueues its CSS (from the `/css/` folder) and JavaScript (from the `/js/` folder) assets only on user profile pages.

== Media Uploader Integration ==
The plugin leverages the WordPress Media Uploader to enable users to select or upload a new profile photo. JavaScript localization passes translated strings and custom button texts to the front-end script.

== Usage ==
When editing or creating a user profile, the plugin displays:
* A preview of the current profile photo (or a placeholder if none is set).
* An input field containing the URL of the uploaded photo.
* Action buttons to upload or remove the profile photo.
* A set of controls for applying filters and style adjustments (brightness, contrast, saturation, grayscale, border styling, and corner rounding).

Uploaded photo URLs and filter settings are saved to user meta and applied dynamically to the user’s avatar using inline CSS.

== Custom Avatar Functionality ==
The plugin hooks into the `get_avatar` filter. If a user has an uploaded profile photo, it constructs an `<img>` element with the applied custom styles and returns it as the user’s avatar.

== Admin Users List Enhancement ==
A custom column is added in the WordPress admin users list to display the user’s profile photo with applied filters, facilitating quick identification.

== Code Structure ==
* **Main Plugin File:** Contains core functionalities such as settings registration, media uploader integration, and avatar customization.
* **CSS & JS Directories:**
  * **CSS:** Contains styles for the user profile photo interface.
  * **JS:** Contains the script for handling media uploads and filter application.
* **Languages Directory:** Contains translation files.
* **Hooks & Filters:**
  * Loads text domain using `plugins_loaded`.
  * Registers settings on `admin_init`.
  * Adds a settings page under `admin_menu`.
  * Integrates with user profile pages via `personal_options` and `user_new_form`.
  * Saves data using `personal_options_update`, `edit_user_profile_update`, and `user_register`.
  * Customizes avatars with the `get_avatar` filter.
  * Enhances the admin users list via custom columns.

== Customization & Extensibility ==
Developers can extend the plugin by:
* Modifying or adding new filter options.
* Adjusting JavaScript and CSS to match their theme’s style.
* Utilizing available hooks and filters to integrate additional functionality.

== Support & Updates ==
For support, documentation, or to report issues, please visit the plugin website: [https://www.rubyvio.com](https://www.rubyvio.com). Future updates and enhancements will be documented in the changelog provided with each new release.

== Changelog ==
= 1.0 =
* Initial release with basic functionality for profile photo upload using the WordPress Media Uploader.
* Basic settings page for customizing upload and remove button texts.
* Display of the uploaded photo as a preview on the user profile.

= 1.0.1 =
* Minor bug fixes and improvements in photo preview display.
* Enhanced sanitization and inline documentation.

= 1.1 =
* Added image editing controls: brightness, contrast, saturation, and grayscale.
* Introduced preset filters (e.g., sepia, grayscale, high contrast, high brightness, vintage, cool, warm, duotone, dramatic).
* Expanded the UI on the user profile page with filter controls.
* Updated settings to allow customization of filter options.

= 1.1.1 =
* UI enhancements: Adjusted display order to show the plugin fields between "Personal Options" and "Name".
* Improved responsiveness and layout adjustments for various screen sizes.

= 1.2 =
* Added nonce verification and improved sanitization (using wp_unslash() and proper escaping functions) for all input data.
* Enhanced output escaping by replacing direct _e() calls with esc_html_e() and esc_attr_e() where appropriate.
* Updated code structure and documentation to comply with WordPress.org coding standards.

= 1.2.1 =
* Readme and documentation updates: Added "Tested up to:" header and ensured Stable Tag matches the plugin version.
* Fixed additional escaping warnings as per WordPress Plugin Guidelines.

= 1.2.2 (Final Stable Release) =
* Final refinements in media uploader integration and filter controls.
* Ensured plugin fields are displayed between "Personal Options" and "Name" on all user profile pages, including new user creation.
* Complete compliance with WordPress.org guidelines regarding security, versioning, and internationalization.

