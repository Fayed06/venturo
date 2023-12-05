# Sales Report Application

## Overview

This application provides a comprehensive report on sales data, categorized by menu items and their respective categories. It allows users to select a year and view the total sales for each menu item per month and the overall total for the year. The report differentiates between categories like 'Makanan' (Food) and 'Minuman' (Beverages), with subtotals for each category and a grand total at the bottom of the report.

## Features

- **Year Selection**: Users can select a year to view sales data from a dropdown menu.
- **Categorized Data**: Sales data is neatly categorized under 'Makanan' and 'Minuman'.
- **Monthly Breakdown**: Each menu item's sales are broken down by month.
- **Subtotals and Grand Total**: Each category has a subtotal, and there is a grand total for all categories at the end of the report.

## Screenshots

Below are screenshots of the application's interface:

### Sales Report Screen

![Sales Report Screen](https://drive.google.com/uc?export=view&id=1QC-vhQvfXhoOSVFSRdxohPjUCkAv3nDV)

_The main screen showing the sales report with category breakdowns and totals._

## Installation

1. Clone the repository to your local machine.
2. Navigate to the project directory and install dependencies with `composer install`.
3. Copy `.env.example` to `.env` and configure your environment variables.
4. Generate an application key using `php artisan key:generate`.
5. Run migrations with `php artisan migrate` (make sure your database is set up correctly).
6. Seed the database if necessary with `php artisan db:seed`.
7. Start the server using `php artisan serve`.

## Usage

To view the sales report:
1. Navigate to the application's homepage.
2. Use the dropdown to select a year.
3. Click the "Tampilkan" button to display the sales report for the selected year.

## Contributing

We welcome contributions to this project. If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

Don't forget to give the project a star! Thanks again!

## License

Distributed under the MIT License. See `LICENSE` for more information.
