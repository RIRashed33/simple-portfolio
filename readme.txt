Features

Portfolio Custom Post Type – Manage portfolio items separately from regular posts.
Custom Meta Fields – Add Project Type and Project URL to each item.
Portfolio Categories – Organize projects with a custom taxonomy.
Shortcode with Options – Display portfolios anywhere using [simple_portfolio]:
posts_per_page – Number of items per page.
type – Filter by Project Type.
Pagination included.
Single Portfolio Template – Custom single page view for portfolio items.
Public API Access – Securely retrieve portfolio data using a generated Secret Key:
List API – Fetch portfolio items with optional:
Filter by type (Project Type).
Pagination control with page parameter.
Limit results using posts_per_page.
Single API – Fetch details of a specific portfolio item by its ID.

📥 Installation
Download & Upload

1.Download the simple-portfolio.zip file.
In WordPress Dashboard, go to Plugins → Add New → Upload Plugin.
Choose the ZIP file and click Install Now.

2.Activate the Plugin
After installation, click Activate.
You’ll now see a new Portfolio menu in your dashboard.

📌 Creating a Portfolio Item
Go to Portfolio → Add New.
Enter a Title (e.g., Website Redesign Project).
Add your Description in the editor.
Featured Image – Upload a main project image (this will be the portfolio thumbnail).
Project Type – Choose an existing type or create a new one.
Custom Fields (in meta box):
Client name (text field for extra info)
Project URL (text field for extra info)
Click Publish.

🏷 Adding Project Type (Taxonomy)
Go to Portfolio → Project Types.
Enter the Name (e.g., Web Design, Photography, Branding).
Click Add New Project Type.
When creating or editing a portfolio item, select the appropriate Project Type from the right-hand sidebar.

✅ Quick Example
Project Title: E-commerce Store
Description: “Full online store with WooCommerce.”
Featured Image: Screenshot of the store.
Client Name: Rashedul Islam
Project Type: Web Development
Project URL: https://example.com


Shortcode name:
================================
[portfolio_list]

Attributes:
type (optional): Filter portfolio items by a specific portfolio type (taxonomy term slug).

post_per_page (optional): Number of portfolio items to show per page (default 6).

Description:
Displays a paginated list of Portfolio posts, optionally filtered by portfolio type.

Example usage:
[portfolio_list]

// Show 10 portfolio items per page:
[portfolio_list post_per_page="10"]

// Show portfolio items only of type "web-design", 5 items per page:
[portfolio_list type="web-design" post_per_page="5"]

Pagination:
The shortcode automatically adds pagination links below the portfolio list to navigate between pages.



API Documentation
===============================

Authentication
------------------
Requires x-api-key header with valid API key
Content-Type must be application/json


Generating API Keys
-------------------
Go to WordPress admin dashboard
Navigate to Settings → Portfolio API
Click "Generate New API Key" button
Copy the generated key (displayed in the table)

Endpoints
---------------------
1. Get Portfolio List
GET /wp-json/simple-portfolio/v1/portfolio-list

Parameters:
---------------
page (optional) - Page number (default: 1)
per_page (optional) - Items per page (default: 12)
type (optional) - Filter by project type slug

JavaScript Fetch Example
---------------------------
fetch('https://yoursite.com/wp-json/simple-portfolio/v1/portfolio-list?page=1&per_page=5', {
  method: 'GET',
  headers: {
    'Content-Type': 'application/json',
    'x-api-key': 'your-api-key-here'
  }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));

curl Example
---------------------------
curl -X GET \
  "http://yoursite.com/wp-json/simple-portfolio/v1/portfolio-list?page=1&per_page=5&type=web-design" \
  -H "Content-Type: application/json" \
  -H "x-api-key: your-api-key-here"

Example Response:
--------------------
{
  "total_posts": 15,
  "total_pages": 3,
  "current_page": 1,
  "posts_per_page": 5,
  "posts": [
    {
      "id": 42,
      "title": "Website Redesign",
      "client_name": "Acme Corp",
      "thumb_url": "http://yoursite.com/wp-content/uploads/2023/01/project1.jpg",
      "description": "<p>Complete website redesign for Acme Corp...</p>",
      "short_description": "Complete website redesign",
      "project_url": "https://acme-corp.com"
    },
    {
      "id": 38,
      "title": "E-commerce Platform",
      "client_name": "ShopRight",
      "thumb_url": "http://yoursite.com/wp-content/uploads/2023/01/project2.jpg",
      "description": "<p>Custom e-commerce solution...</p>",
      "short_description": "Custom e-commerce solution",
      "project_url": "https://shopright.com"
    }
  ]
}


2. Get Single Portfolio Item
GET /wp-json/simple-portfolio/v1/portfolio

Parameters:
----------------
id (required) - Portfolio item ID

JavaScript Fetch Example
---------------------------
fetch('https://yoursite.com/wp-json/simple-portfolio/v1/portfolio?id=42', {
  method: 'GET',
  headers: {
    'Content-Type': 'application/json',
    'x-api-key': 'your-api-key-here'
  }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));

curl Example
---------------------------
curl -X GET \
  "http://yoursite.com/wp-json/simple-portfolio/v1/portfolio?id=42" \
  -H "Content-Type: application/json" \
  -H "x-api-key: your-api-key-here"

Example Response:
--------------------
{
  "id": 42,
  "title": "Website Redesign",
  "client_name": "Acme Corp",
  "thumb_url": "http://yoursite.com/wp-content/uploads/2023/01/project1-full.jpg",
  "description": "<p>Complete website redesign for Acme Corp...</p>",
  "short_description": "Complete website redesign",
  "project_url": "https://acme-corp.com"
}


Error Handling
================================
Status Code       Error                      Solution
-----------------------------------------------------------------------------
400	              Missing API key	           Include x-api-key header
401	              Invalid API key	           Generate a new key or use correct one
404	              Portfolio not found	       Check the portfolio ID exists
415	              Invalid Content-Type	     Set Content-Type to application/json

Example Implementation
==============================
<div id="portfolio-container"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const apiKey = 'your-api-key-here';
  const container = document.getElementById('portfolio-container');
  
  fetch(`https://yoursite.com/wp-json/simple-portfolio/v1/portfolio-list?per_page=6`, {
    headers: {
      'Content-Type': 'application/json',
      'x-api-key': apiKey
    }
  })
  .then(response => response.json())
  .then(data => {
    data.posts.forEach(item => {
      const project = document.createElement('div');
      project.className = 'portfolio-item';
      project.innerHTML = `
        <img src="${item.thumb_url}" alt="${item.title}">
        <h3>${item.title}</h3>
        <p>${item.short_description}</p>
        <a href="${item.project_url}" target="_blank">View Project</a>
      `;
      container.appendChild(project);
    });
  })
  .catch(error => {
    console.error('Error loading portfolio:', error);
    container.innerHTML = '<p>Error loading portfolio items. Please try again later.</p>';
  });
});
</script>