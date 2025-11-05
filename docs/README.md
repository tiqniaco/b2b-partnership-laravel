# B2B Partnership Laravel API Documentation

## Overview

This is the complete API documentation for the B2B Partnership platform. The API provides comprehensive endpoints for user management, store operations, secure downloads, push notifications, and administrative features.

## 🚀 Quick Start

### Base URLs
- **Local Development**: `http://localhost:8000/api`
- **Production**: `https://api.tiqnia.com/api`

### Authentication
Most endpoints require authentication using Bearer tokens obtained from the login endpoint.

```bash
# Login to get token
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"login": "user@example.com", "password": "password123"}'

# Use token in subsequent requests
curl -X GET http://localhost:8000/api/store/my-download-tokens \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## 📚 Documentation Formats

### 1. OpenAPI/Swagger Specification
- **File**: `docs/openapi.yaml`
- **Usage**: Import into Swagger UI, Postman, or any OpenAPI-compatible tool
- **Online Viewer**: Copy content to [editor.swagger.io](https://editor.swagger.io/)

### 2. Postman Collection
- **File**: `docs/postman_collection.json`
- **Import**: Postman → Import → Upload Files → Select `postman_collection.json`
- **Variables**: Set `{{base_url}}` and `{{access_token}}` in collection variables

### 3. Insomnia Collection
The OpenAPI specification is compatible with Insomnia REST client.

## 🔑 Key Features

### 1. **Secure Download System**
- Demo file downloads (public access)
- Token-based secure downloads with expiration
- Download limits and tracking
- Admin-configurable settings

### 2. **FCM Push Notifications**
- User FCM token registration
- Individual and bulk notifications
- Admin notification management
- Test notification endpoints

### 3. **Admin Reports & Analytics**
- Dashboard statistics
- Download reports
- Order analytics
- User activity tracking

### 4. **Role-Based Access Control**
- Client, Provider, and Admin roles
- Protected endpoints with middleware
- Role-specific functionality

## 📖 API Endpoints Overview

### Authentication (`/auth`)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/auth/register` | Register new user | ❌ |
| POST | `/auth/login` | User login | ❌ |
| POST | `/auth/logout` | User logout | ✅ |
| POST | `/auth/update-profile` | Update profile | ✅ |
| POST | `/auth/forget-password` | Password reset | ❌ |

### Store & Products (`/store`)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/store/categories` | Get categories | ❌ |
| GET | `/store/products` | Get products | ❌ |
| GET | `/store/products/{id}/demo` | Download demo | ❌ |
| GET | `/store/top-selling-products` | Top selling | ❌ |
| POST | `/store/carts` | Add to cart | ✅ |
| GET | `/store/carts` | Get cart items | ✅ |

### Download System
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/store/generate-download-token` | Generate token | ✅ |
| GET | `/store/my-download-tokens` | User's tokens | ✅ |
| GET | `/download/{token}` | Download by token | ❌ |
| GET | `/store/download-config` | Get config | ✅ |

### FCM Notifications (`/fcm`)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/fcm/register-token` | Register FCM token | ✅ |
| POST | `/fcm/update-token` | Update FCM token | ✅ |
| DELETE | `/fcm/remove-token` | Remove FCM token | ✅ |
| POST | `/fcm/test-notification` | Test notification | ✅ |

### Admin Reports (`/admin/reports`)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/admin/reports/dashboard` | Dashboard stats | ✅ Admin |
| GET | `/admin/reports/downloads` | Download reports | ✅ Admin |
| GET | `/admin/reports/orders` | Order analytics | ✅ Admin |
| GET | `/admin/reports/products-performance` | Product stats | ✅ Admin |

### Admin Settings (`/admin/download-settings`)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/admin/download-settings` | Get all settings | ✅ Admin |
| POST | `/admin/download-settings/update` | Update setting | ✅ Admin |
| POST | `/admin/download-settings/reset` | Reset to defaults | ✅ Admin |

### Public Data
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/countries` | Get countries | ❌ |
| GET | `/governments` | Get governments | ❌ |
| GET | `/specializations` | Get specializations | ❌ |
| GET | `/provider-types` | Get provider types | ❌ |

## 🔒 Authentication & Authorization

### Token-Based Authentication
The API uses Laravel Sanctum for authentication. After successful login, you receive a Bearer token.

```json
{
  "status": "success",
  "message": "Login successfully.",
  "user_id": 1,
  "role_id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "1234567890",
  "role": "client",
  "token": "1|abcdef123456..."
}
```

### Using Tokens
Include the token in the Authorization header:

```bash
Authorization: Bearer 1|abcdef123456...
```

### Role-Based Access
- **Public**: No authentication required
- **User**: Requires valid user token
- **Admin**: Requires admin role token

## 📊 Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { /* response data */ }
}
```

### Error Response
```json
{
  "status": "error",
  "message": "Error description",
  "error": "Detailed error message"
}
```

### Validation Error
```json
{
  "status": "error",
  "message": "Validation error",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 6 characters."]
  }
}
```

## 🚀 NEW FEATURES

### 1. Download Token System
- **Demo Downloads**: Public access to demo files
- **Secure Downloads**: Token-based system with expiration
- **Download Limits**: Configurable maximum downloads per token
- **Email Notifications**: Automatic email triggers on order status changes

**Example Usage**:
```bash
# Generate download token
curl -X POST http://localhost:8000/api/store/generate-download-token \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "user_id": 1,
    "order_id": 1,
    "expires_in_hours": 24,
    "max_downloads": 5
  }'

# Download using token
curl -X GET http://localhost:8000/api/download/abc123def456...
```

### 2. FCM Push Notifications
- **Token Registration**: Register device FCM tokens
- **Individual Notifications**: Send to specific users
- **Bulk Notifications**: Send to user groups/roles
- **Admin Controls**: Administrative notification management

**Example Usage**:
```bash
# Register FCM token
curl -X POST http://localhost:8000/api/fcm/register-token \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "fcm_token": "fGHJ123...fcmTokenString",
    "device_type": "android"
  }'
```

### 3. Admin Reports & Analytics
- **Dashboard Statistics**: Comprehensive system overview
- **Download Analytics**: Track download patterns and usage
- **Order Reports**: Sales and order analytics
- **User Activity**: User engagement metrics

### 4. Configurable Download Settings
- **Database-Driven**: All settings stored in database
- **Admin Control**: Update settings through API
- **Type Safety**: Support for different value types (string, integer, boolean)

## 🛠️ Setup Instructions

### 1. Swagger UI Setup

#### Option A: Local Setup
```bash
# Install swagger-ui-dist
npm install swagger-ui-dist

# Create simple HTML file
cat > public/api-docs.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
  <title>API Documentation</title>
  <link rel="stylesheet" type="text/css" href="node_modules/swagger-ui-dist/swagger-ui.css" />
</head>
<body>
  <div id="swagger-ui"></div>
  <script src="node_modules/swagger-ui-dist/swagger-ui-bundle.js"></script>
  <script>
    SwaggerUIBundle({
      url: '/docs/openapi.yaml',
      dom_id: '#swagger-ui',
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIBundle.presets.standalone
      ]
    });
  </script>
</body>
</html>
EOF
```

#### Option B: Online Viewer
1. Copy content from `docs/openapi.yaml`
2. Go to [editor.swagger.io](https://editor.swagger.io/)
3. Paste the content
4. View and test the API

### 2. Postman Setup
1. Open Postman
2. Click "Import" → "Upload Files"
3. Select `docs/postman_collection.json`
4. Set collection variables:
   - `base_url`: `http://localhost:8000/api`
   - `access_token`: (will be set automatically after login)

### 3. Insomnia Setup
1. Open Insomnia
2. Create new collection
3. Import from `docs/openapi.yaml`

## 📝 Testing Examples

### Test Authentication Flow
```bash
# 1. Register user
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "phone": "1234567890",
    "country_code": "+20",
    "role": "client"
  }'

# 2. Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "login": "test@example.com",
    "password": "password123"
  }'

# 3. Use token for protected endpoints
curl -X GET http://localhost:8000/api/store/my-download-tokens \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Test Download System
```bash
# 1. Download demo (no auth)
curl -X GET http://localhost:8000/api/store/products/1/demo

# 2. Generate download token (auth required)
curl -X POST http://localhost:8000/api/store/generate-download-token \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "user_id": 1,
    "order_id": 1
  }'

# 3. Download using token
curl -X GET http://localhost:8000/api/download/GENERATED_TOKEN
```

### Test FCM Notifications
```bash
# 1. Register FCM token
curl -X POST http://localhost:8000/api/fcm/register-token \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "fcm_token": "your-fcm-token-here",
    "device_type": "android"
  }'

# 2. Send test notification
curl -X POST http://localhost:8000/api/fcm/test-notification \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Notification",
    "body": "This is a test message"
  }'
```

## 🔧 Environment Variables

Make sure these are set in your `.env` file:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=b2b_partnership
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Firebase (for FCM)
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_PRIVATE_KEY="-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n"
FIREBASE_CLIENT_EMAIL=firebase-adminsdk@your-project.iam.gserviceaccount.com

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="B2B Partnership"

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

## 📞 Support

For API support or questions:
- **Email**: support@tiqnia.com
- **Documentation Issues**: Create issue in repository
- **Feature Requests**: Contact development team

## 📄 License

This API documentation is licensed under MIT License.

---

**Last Updated**: November 5, 2025
**API Version**: 1.0.0
