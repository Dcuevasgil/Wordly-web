# 🔐 Módulo Auth

## 🎯 Objetivo
Gestionar autenticación, registro, login y sesión del usuario.

---

## 🗄️ Tablas implicadas
- users
- password_resets (opcional)

---

## 🧠 Modelos

### User.php
Tabla: users

Campos:
- id_users
- name
- email
- password
- role
- is_user_active
- last_access
- register_date
- updated_date

---

## 🎮 Controladores

### AuthController.php

Métodos:
- register()
- login()
- me()
- logout()

---

## 🗄️ Migraciones

### create_users_table.php
Campos:
- id_users (PK)
- name
- email (unique)
- password
- role (user/admin)
- is_user_active
- last_access
- register_date
- updated_date

---

### create_password_resets_table.php
Campos:
- id_password_reset (PK)
- user_id (FK → users)
- reset_token
- expires_at
- used
- register_date
- update_date

---

## 🧾 Requests

### RegisterRequest.php
Valida:
- name (required)
- email (required, email, unique)
- password (required)

### LoginRequest.php
Valida:
- email (required, email)
- password (required)

---

## 📦 Resources

### UserResource.php

Devuelve:
- id_users
- name
- email
- role
- is_user_active
- last_access

---

## ⚙️ Services (opcional)

### AuthService.php

Responsabilidades:
- registrar usuario
- login
- generación de token

---

## 🌐 Endpoints

- POST /api/register
- POST /api/login
- GET /api/me
- POST /api/logout
