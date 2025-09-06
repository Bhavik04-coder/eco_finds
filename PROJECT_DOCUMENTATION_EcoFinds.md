# EcoFinds - Sustainable Second-Hand Marketplace

**Project Document**

---

## Project Title
**EcoFinds - Sustainable Second-Hand Marketplace**

## The Challenge
**EcoFinds – Empowering Sustainable Consumption through a Second-Hand Marketplace**

## Overall Vision
The overarching vision for EcoFinds is to create a vibrant and trusted platform that revolutionizes the way people buy and sell pre-owned goods. It aims to foster a culture of sustainability by extending the lifecycle of products, reducing waste, and providing an accessible and convenient alternative to purchasing new items. EcoFinds envisions becoming the go-to destination for a conscious community seeking unique finds and responsible consumption.

## Mission
The mission for the hackathon team is to develop a user-friendly and engaging desktop and mobile application that serves as a central hub for buying and selling second-hand items. EcoFinds should leverage intuitive design and essential features to connect buyers and sellers efficiently, promoting a circular economy and making sustainable choices easier for everyone. This involves building a platform that is both functional and inspires trust and community.

## Problem Statement
Develop a foundational version of EcoFinds, focusing on core user authentication and product listing functionalities. Teams must deliver a functional prototype, accessible via both mobile and desktop interfaces, that allows users to register and log in, create and manage basic product listings (including title, description, category, price, and at least one image placeholder), and browse these listings with basic filtering and search capabilities. The system must employ efficient data structures for managing user and product data, ensuring a stable and responsive user experience.

### Core Requirements
- **User Authentication:** A simple and secure mechanism for user registration and login (e.g., email and password).
- **Profile Creation (Basic):** Ability for users to set a username.
- **User Dashboard:** Users should be able to edit all profile fields.
- **Product Listing Creation:** Create new product listings with title, description, predefined category, price, and at least one image placeholder.
- **Product Listing Management (CRUD - Basic):** Users can view, edit, and delete their own product listings.
- **Product Browsing:** Display a list of available product listings with basic info (title, price, placeholder image).
- **Category Filtering:** Filter listings by predefined categories.
- **Keyword Search:** Basic search on listing titles.
- **Product Detail View:** Show full details of a selected product (title, description, price, category, image).
- **Previous Purchase View:** Show products previously purchased by the user.
- **Cart:** Display all products added to the cart.

## Wireframes and UI Elements (Functional Description)

### Login / Sign Up Screen
Elements:
- App logo
- Email input
- Password input
- Login button
- Sign-up link/button

### Product Listing Feed Screen
Elements:
- Header with app title/logo
- Search bar
- Category filter options (tappable buttons or dropdown)
- List of product items (each showing placeholder image, title, and price)
- Prominent "+" button to add a new product listing

### Add New Product Screen
Elements:
- Back button
- Screen title: "Add New Product"
- Input fields:
  - Product Title
  - Category (dropdown)
  - Description (text area)
  - Price (number input)
- "+ Add Image (Placeholder)" button
- "Submit Listing" button

### My Listings Screen
Elements:
- Header with app title/logo
- "+" button to add a new product
- List of user's listed products (each with placeholder image, title, price, and "Edit" and "Delete" buttons)

### Product Detail Screen
Elements:
- Back button
- Larger product image placeholder
- Product title
- Price
- Category
- Description

### User Dashboard
Elements:
- Header with app title/logo
- User profile image
- Display of all user fields and ability to edit them

### Cart
Elements:
- Header with app title/logo
- Page lists all products added to cart in card format with basic product info and quantity controls

### Previous Purchase
Elements:
- List view of products purchased in the past by the current user

## Implementation Notes
- Keep the existing project structure and database as-is. The document should be added to the repository for reference.
- The prototype should be accessible via desktop and mobile responsive layouts.
- Use prepared statements for DB operations and validate/sanitize all user input.
- Store uploaded images in the existing `uploads/` folder with safe filenames.
- Provide clear error messages and confirmations for user actions (create/update/delete).

## Deliverables
- A working prototype with:
  - User registration and login
  - Profile editing
  - Product creation, edit, delete
  - Listing feed with search and category filter
  - Product detail view
  - Cart and previous purchases pages
- This project document (this file) included in the project root.

---

**Document prepared for the EcoFinds hackathon submission.**
