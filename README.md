# ERPNext Frappy (Laravel Integration)

A modern Laravel 12 implementation for managing **ERPNext Sales Orders** via the Frappe API. This project provides a seamless interface to Create, Read, Update, and Delete (CRUD) Sales Orders while maintaining synchronized document statuses with your ERPNext instance.

## 🚀 Features

- **Full Sales Order CRUD**: Manage orders, items, and customers from a custom Laravel dashboard.
- **Frappe API Integration**: Direct communication with `{your_frappy_name}.frappe.cloud`.
- **Dynamic Item Management**: Add/Remove item rows dynamically using JavaScript.
- **ERP Status Mapping**: Handles `docstatus` (0: Draft, 1: Submitted, 2: Cancelled) to match ERPNext logic.
- **Tailwind CSS UI**: Clean, responsive interface using the standard Laravel starter kit layout.

## 🛠 Tech Stack

- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js (optional)
- **API**: Frappe API (REST)

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- An active ERPNext/Frappe instance (e.g., `{your_frappy_name}.frappe.cloud`)
- ERPNext API Key and API Secret (generated from the User document in ERPNext)

## ⚙️ Installation

1. **Clone the repository**:
   ```bash
   git clone [https://github.com/shibusharma1/erpnext-frappy.git](https://github.com/shibusharma1/erpnext-frappy.git)
   cd erpnext-frappy
Install dependencies:

Bash
composer install
npm install && npm run build
Environment Setup:
Copy the .env.example to .env and configure your ERPNext credentials:

Code snippet
ERPNEXT_URL=[https://{your_frappy_name}.frappe.cloud](https://{your_frappy_name}.frappe.cloud)
ERPNEXT_API_KEY=your_api_key
ERPNEXT_API_SECRET=your_api_secret
Generate App Key:

Bash
php artisan key:generate
📖 Usage
Sales Order Status Logic
This application uses docstatus to control the lifecycle of a Sales Order:

0 (Draft): Order is saved in ERPNext but can still be edited or deleted.

1 (Submitted): Order is finalized. This triggers ledger entries in ERPNext.

2 (Cancelled): Order is voided.

API Payload Example
The controller formats the data to match the Frappe Sales Order Doctype requirements:

```json
{
  "doctype": "Sales Order",
  "customer": "John Doe",
  "docstatus": 0,
  "company": "{your_frappy_name}D",
  "items": [
    {
      "item_code": "IOC2",
      "qty": 10,
      "rate": 200
    }
  ]
}
🤝 Contributing
Fork the Project

Create your Feature Branch (git checkout -b feature/AmazingFeature)

Commit your Changes (git commit -m 'Add some AmazingFeature')

Push to the Branch (git push origin feature/AmazingFeature)

Open a Pull Request

📄 License
Distributed under the MIT License. See LICENSE for more information.
