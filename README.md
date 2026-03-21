# KeepNote API Clone (Laravel)

A **backend API** for a Keep-style notes app, built with **Laravel**. This project demonstrates practical backend and architecture skills, highlighting:

- **Secure Authentication & Authorization** – implemented with **Laravel Sanctum** for token-based authentication, **role-based access control (RBAC)**, session handling, and secure password hashing.  
- **RESTful API Design** – clean and consistent endpoints following REST conventions, suitable for future **frontend integration** or mobile apps.  
- **CRUD Operations** – full **create, read, update, delete** support for notes, todos, and labels with proper **request validation** using **Laravel Form Requests**.  
- **Database Design & Relationships** – relational schema with **Eloquent ORM**, leveraging **one-to-many** and **many-to-many** relationships for notes, todos, users, and labels.  
- **Validation & Error Handling** – robust **input validation**, custom error messages, and consistent **JSON API responses** with HTTP status codes.  
- **Soft Deletes & Activity Management** – **soft deletion** using Eloquent `SoftDeletes`, with activity logs to track changes safely.  
- **Middleware & Services** – request filtering, logging, and **service layer separation** to keep controllers lean and maintainable.  
- **Testing & Quality Assurance** – **PHPUnit** and **Laravel's testing utilities** for unit and feature tests, ensuring endpoint reliability and data integrity.  
- **Scalable Architecture** – modular project structure, **repository-service pattern**, and use of **API resources** to support future growth and maintainability.  

This project is a **learning-focused implementation**, but demonstrates a **production-ready approach** to building a modern Laravel backend API for note-taking applications.
