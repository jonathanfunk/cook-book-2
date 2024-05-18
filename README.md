# Recipe App

## Overview

The Recipe App allows users to discover, share, and explore various recipes. Users can add their own recipes, browse recipes by category, and interact with the cooking community.

## Features

- **Recipe Creation**: Users can create and share their own recipes, including ingredients, instructions, and images.
- **Recipe Filtering**: Browse recipes by category, such as Breakfast, Lunch, Dinner, and Dessert.
- **Pagination**: Navigate through multiple pages of recipes for easy browsing.
- **User Authentication**: Secure user accounts with login and registration functionality.
- **Recipe Management**: Edit and delete recipes that users have created.

## Technologies Used

- HTML5
- CSS3 (Bootstrap 5)
- JavaScript (ES6+)
- PHP (with MySQL)
- Cloudinary API (for image storage and transformations)
- Gravatar (for user avatars)

## Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/jonathanfunk/cook-book-2.git
   cd cookbook
   ```
2. Set up the database:

- Create a MySQL database and import the provided SQL file to set up the necessary tables.

3. Set up environment variables:

- Create a .env file in the root directory.
- Add your Cloudinary API key, secret, and other configuration details to the .env file:

```
DB_HOST='localhost'
DB_NAME='recipe_app'
DB_USER='root'
DB_PASS='root'
CLOUDINARY_CLOUD_NAME='your_cloud_name'
CLOUDINARY_API_KEY='your_api_key'
CLOUDINARY_API_SECRET='your_api_secret'
```

4. Install dependencies:

- If you use a local server environment like XAMPP or MAMP, ensure it's running.
- Make sure you have Composer installed, then run:

```
composer install
```

5.Start the application:

- Open your preferred browser and navigate to http://localhost/path-to-your-project.

## API Key

To use the Cloudinary API, you need to sign up and get your API key. Add your Cloudinary credentials to the .env file as shown in the Setup section.

## Contribution

Feel free to fork this repository and submit pull requests. For major changes, please open an issue first to discuss what you would like to change.
