<div align="center">
  <img src="public/images/sksu.png" alt="SKSU Logo" width="120" height="120">
  
  # SKSU Student Complaints & Assistance Desk System
  
  <p>
    <b>Digitalizing Grievance Redressal for Sultan Kudarat State University</b>
  </p>

  <p>
    <a href="https://laravel.com">
      <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    </a>
    <a href="https://tailwindcss.com">
      <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind" />
    </a>
    <a href="https://php.net">
      <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    </a>
    <a href="https://mysql.com">
      <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    </a>
  </p>
</div>

<br />

## 👥 The Research & Development Team

This system was designed and developed by the following researchers/developers from **Sultan Kudarat State University**:

| Team Member | Role |
| :--- | :--- |
| **Stephanie D. Villanueva** | 
| **Alayssa Cream N. Rufino** |
| **Cathleen Joy D. Cagunda** | |
| **Reynalyn D. Bautista** |
| **Mikyla F. Sucaldito** | 
| **Bea E. Marquez** |
| **Blessie Jane L. Gabut** 

--------------

## 📖 About The Project

The **SKSU Student Complaints and Assistance Desk System** is a web-based platform designed to streamline the filing, routing, and resolution of student grievances. By transitioning from manual processes to a centralized digital dashboard, this system ensures transparency, accountability, and efficiency in handling student concerns.

### 🎯 Objectives
* **Centralized Routing:** Administrators can validate and route complaints to specific offices (Registrar, Finance, Guidance, etc.).
* **Real-time Tracking:** Students can monitor the status of their requests from "Pending" to "Resolved."
* **Office Efficiency:** Office personnel have a dedicated queue to process tasks and submit official resolutions.
* **Transparency:** Automated email notifications keep all parties informed at every step of the workflow.

---

## 🚀 Key Features

### 🎓 For Students
* **Secure Profile Management:** Manage personal details and secure login.
* **Direct Filing:** Submit complaints targeting specific university offices.
* **Evidence Support:** Attach images or documents to support claims.
* **Live Status Tracker:** View real-time updates (e.g., *Sent to Office*, *Under Review*, *Resolved*).

### 🛡️ For Administrators
* **Gatekeeper Workflow:** Review incoming complaints before they reach office staff.
* **Smart Routing:** Assign or Re-route complaints to the correct department.
* **Office Management:** Create and manage office accounts and personnel credentials.
* **Resolution Review:** Validate office actions before notifying the student.

### 🏢 For Office Personnel
* **Dedicated Queue:** View only the complaints assigned to your specific office.
* **Action & Resolution:** Submit official remarks and attach response files.
* **History Logs:** Maintain a searchable record of all processed complaints.

---

## 💻 Tech Stack

* **Framework:** Laravel 11 / 12
* **Styling:** Tailwind CSS (via Laravel Breeze)
* **Scripting:** Alpine.js (for interactive UI components)
* **Database:** MySQL
* **Mail Service:** SMTP (Mailtrap/Gmail) for notifications

---|

---

## 🛠️ Installation & Setup

To run this project locally, follow these steps:

<details>
<summary><b>Click to expand installation instructions</b></summary>

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/your-username/sksu-complaints.git](https://github.com/your-username/sksu-complaints.git)
    cd sksu-complaints
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install NPM Dependencies**
    ```bash
    npm install
    npm run build
    ```

4.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Configure your database name and mail settings in the `.env` file.*

5.  **Database Migration & Seeding**
    ```bash
    php artisan migrate:fresh --seed
    ```
    *(This creates the Admin, Student, and Office accounts).*

6.  **Run the Server**
    ```bash
    php artisan serve
    ```

</details>

---

## 🔐 Default Credentials (Seeders)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@sksu.edu.ph` | `password` |
| **Office Personnel** | `office@sksu.edu.ph` | `password` |
| **Student** | `student@sksu.edu.ph` | `password` |

---

<div align="center">
  <p>Made with ❤️ by the SKSU Student Team</p>
</div>
