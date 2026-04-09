# CholeraCare 💧

A water monitoring and alert system designed to help detect and manage cholera risks through real-time data tracking and analytics.

---

## 🚀 Getting Started

Follow these steps to run the project locally:

### 1. Start the Server

```bash
php artisan serve
```

Then open your browser and go to:

```
http://127.0.0.1:8000
```

---

### 2. Set Up the Database

#### Option A (Recommended)

Import the provided database:

* Open **phpMyAdmin**
* Create a database named:

  ```
  assignment
  ```
* Import the SQL file located in the project’s `database` folder

This option includes preloaded data and users.

#### Option B

Run migrations on an empty database:

```bash
php artisan migrate
```

---

## 🔐 Login Credentials

Use the following admin account:

* **Email:** [admin@gmail.com](mailto:admin@gmail.com)
* **Password:** admin001

---

## 🧩 Features

* Real-time water quality monitoring
* Alert system for contamination risks
* Dashboard with analytics
* Sensor data tracking and management
* User authentication system

---

## 🛠️ Tech Stack

* **Backend:** Laravel (PHP)
* **Database:** MySQL
* **Frontend:** Blade Templates, Bootstrap
* **Server:** Apache (XAMPP recommended)

---

## 📂 Project Structure

```
CholeraCare/
│── app/
│── database/
│── public/
│── resources/
│── routes/
│── README.md
```

---

## ⚠️ Notes

* Ensure XAMPP (or similar) is running before starting the project
* Update your `.env` file with correct database credentials if needed
* Default database name: `assignment`

---

## 📌 Future Improvements

* IoT sensor integration
* SMS/email alert system
* Advanced analytics dashboard
* Mobile app support

---

## 👨‍💻 Author

Developed as part of a water monitoring innovation project.

---

## 📄 License

This project is for educational purposes.
