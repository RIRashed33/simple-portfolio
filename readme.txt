=== Simple Portfolio ===
Contributors: your-name
Tags: portfolio, custom post type, shortcode, api, taxonomy, pagination
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Simple Portfolio allows you to create and manage a portfolio section on your WordPress site with a custom post type, taxonomy, metaboxes, shortcode, and REST API.

== Description ==

Simple Portfolio plugin adds a fully functional Portfolio system with these features:

* Custom Post Type "Portfolio" — to add and manage portfolio projects.
* Custom Meta Boxes — add client name and project URL for each portfolio item.
* Custom Taxonomy "Project Type" — categorize your portfolio projects.
* Shortcode [portfolio_list] — display portfolio items anywhere with filtering and pagination.
* Single Portfolio Page — shows detailed info with featured image, meta, taxonomy, and content.
* REST API Endpoints — access portfolio data securely with secret API keys.

== Features ==

1. Portfolio Custom Post Type
- Manage portfolio projects with title, content, and featured image.
- Meta fields for Client Name and Project URL.
- Custom taxonomy "Project Type" to categorize projects.

2. Shortcode: [portfolio_list]
- Attributes:
    - type: filter by project type slug (e.g. type="web")
    - posts_per_page: number of items to display (default 9)
- Supports pagination automatically when more than one page of items exists.
- Enqueues styles only when shortcode is used.
- Example usage:
    [portfolio_list type="design" posts_per_page="6"]

3. Single Portfolio Page
- Displays featured image, project title, client name, project URL, project types, and full content.

4. REST API Endpoints
- `/wp-json/simple-portfolio/v1/portfolio-list`
  - Returns a paginated list of portfolio items.
  - Supports filtering by taxonomy with the `tag` query param.
  - Supports pagination with `page` and `per_page` params.
- `/wp-json/simple-portfolio/v1/portfolio`
  - Returns single portfolio post by `id`.

5. API Authentication & Usage
- API access requires a secret API key passed in the request header `X-API-Key`.
- Generate and manage API keys from the admin under Settings > Portfolio API.
- The plugin tracks usage count of each API key.
- Invalid or missing keys return proper HTTP errors.

== Installation ==

1. Upload the `simple-portfolio` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add portfolio items via the "Portfolio" menu.
4. Add project types in the "Project Types" taxonomy.
5. Use the shortcode `[portfolio_list]` in pages/posts to display portfolios.
6. Visit single portfolio pages by clicking portfolio items.
7. Manage API keys in WordPress admin under Settings > Portfolio API.

== Frequently Asked Questions ==

= How do I filter portfolio items by type? =

Use the shortcode attribute `type` with the slug of the project type:

`[portfolio_list type="web-design"]`

= How do I paginate the portfolio list? =

Pagination is handled automatically if the total portfolio items exceed the `posts_per_page` value in shortcode.

= How do I get portfolio data via API? =

Generate an API key in Settings > Portfolio API, then call the endpoints with the key in the header `X-API-Key`.

Example GET request with curl:

