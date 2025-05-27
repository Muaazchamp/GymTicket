# GymTicket - Web Application

## 📌 Project Overview
GymTicket is a web-based application that allows users to register, make payments, and manage their profiles. Admins can manage users, view payments, and handle other administrative tasks.

---

## 🛠️ Required Applications
To run this project locally, you need to install the following software:

1. **XAMPP** (Apache, MySQL, PHP): [Download Here](https://www.apachefriends.org/index.html)
2. **VS Code** (Code Editor): [Download Here](https://code.visualstudio.com/)
3. **Google Chrome** (Recommended Browser): [Download Here](https://www.google.com/chrome/)
4. **Composer** (For PHP dependencies, if needed): [Download Here](https://getcomposer.org/)
5. **Postman** (For API Testing - Optional): [Download Here](https://www.postman.com/)

---

## 🔧 Installation Steps

### **1️⃣ Install XAMPP & Start Services**
- Install XAMPP and open the **XAMPP Control Panel**.
- Start **Apache** and **MySQL**.

### **2️⃣ Clone or Download the Project**
- Navigate to your `htdocs` folder inside XAMPP (`C:\xampp\htdocs\`).
- Clone the project using Git (if installed):
  ```sh
  git clone https://github.com/your-repo/GymTicket.git
  ```
- Or manually download and extract the project into `C:\xampp\htdocs\GymTicket\`.

### **3️⃣ Configure the Database**
1. Open **phpMyAdmin** in your browser:
   ```
   http://localhost/phpmyadmin/
   ```
2. Create a new database named **`gym_ticket`**.
3. Import the provided SQL file `database/gym_ticket.sql`:
   - Click **Import** in phpMyAdmin.
   - Select `gym_ticket.sql` file from the `database/` folder.
   - Click **Go** to execute.

### **4️⃣ Configure Database Connection**
- Open `includes/db.php` and update the credentials if needed:
  ```php
  $conn = new mysqli("localhost", "root", "", "gym_ticket");
  ```
  - Default MySQL username: `root`
  - Default MySQL password: *(leave empty)*

### **5️⃣ Start the Server**
- Open a web browser and visit:
  ```
  http://localhost/GymTicket/pages/
  ```

---

## 🚀 Accessing the Web Application

### **🔹 User Login**
- Open `http://localhost/GymTicket/pages/login.php`.
- Enter user credentials to log in.

### **🔹 Admin Login**
- Open `http://localhost/GymTicket/pages/admin_login.php`.
- Enter admin credentials to access the dashboard.

### **🔹 Register a New User**
- Open `http://localhost/GymTicket/pages/register.php`.

### **🔹 Payment Processing**
- Navigate to `http://localhost/GymTicket/pages/payment.php` to make a payment.

---

## 🎯 Troubleshooting

### **Issue: Apache or MySQL Not Starting?**
- Make sure no other application (Skype, VMware, etc.) is using **port 80**.
- Change the Apache port from 80 to **8080** in `httpd.conf`.

### **Issue: Database Connection Failed?**
- Ensure MySQL service is running.
- Check `db.php` for correct credentials.

### **Issue: 500 Internal Server Error?**
- Check `error.log` inside `C:\xampp\apache\logs`.
- Enable `display_errors` in `php.ini`:
  ```ini
  display_errors = On
  ```

---

## 📞 Need Help?
If you face any issues, feel free to ask for help!

Enjoy using **GymTicket**! 🎉

