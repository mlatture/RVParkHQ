# Open Claw Bot API Documentation

## Overview

This API allows the Open Claw bot to directly create and update parks in the RVParkHQ system.

## Authentication

All requests must include a Bearer token in the Authorization header.

```
Authorization: Bearer YOUR_BOT_API_TOKEN
```

### Setup

1. Generate a secure API token (e.g., using `openssl rand -hex 32`)
2. Add the token to your `.env` file:
   ```
   BOT_API_TOKEN=your_generated_token_here
   ```

## Base URL

```
https://your-domain.com/api
```

## Endpoints

### Create Park

Creates a new park in the system.

**Endpoint:** `POST /api/parks`

**Headers:**
```
Authorization: Bearer YOUR_BOT_API_TOKEN
Content-Type: application/json
```

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| name | string | Yes | Park name (max 255 chars) |
| description | string | No | Full description |
| short_description | string | No | Brief description (max 500 chars) |
| address | string | No | Street address |
| city | string | No | City name |
| state | string | No | State/Province |
| country | string | No | Country |
| postal_code | string | No | ZIP/Postal code |
| latitude | string | No | GPS latitude |
| longitude | string | No | GPS longitude |
| phone | string | No | Contact phone |
| email | string | No | Contact email |
| website_url | string | No | Park website URL |
| main_image_url | string | No | URL to park image |
| status | string | No | "active" or "inactive" (default: "active") |
| is_featured | boolean | No | Featured park flag (default: false) |
| amenity_ids | array | No | Array of amenity IDs to attach |

**Example Request:**

```bash
curl -X POST https://your-domain.com/api/parks \
  -H "Authorization: Bearer YOUR_BOT_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Sunny Acres RV Park",
    "description": "A beautiful RV park with full hookups and scenic views.",
    "short_description": "Full hookups, scenic views",
    "address": "123 Park Lane",
    "city": "Austin",
    "state": "Texas",
    "country": "United States",
    "postal_code": "78701",
    "latitude": "30.2672",
    "longitude": "-97.7431",
    "phone": "512-555-0123",
    "email": "info@sunnyacres.com",
    "website_url": "https://sunnyacres.com",
    "status": "active",
    "amenity_ids": [1, 3, 5]
  }'
```

**Success Response (201 Created):**

```json
{
  "message": "Park created successfully",
  "park": {
    "id": 123,
    "name": "Sunny Acres RV Park",
    "slug": "sunny-acres-rv-park",
    "slug_path": "united-states-texas-austin-sunny-acres-rv-park",
    "description": "A beautiful RV park with full hookups and scenic views.",
    "short_description": "Full hookups, scenic views",
    "address": "123 Park Lane",
    "city": "Austin",
    "state": "Texas",
    "country": "United States",
    "postal_code": "78701",
    "latitude": "30.2672",
    "longitude": "-97.7431",
    "phone": "512-555-0123",
    "email": "info@sunnyacres.com",
    "website_url": "https://sunnyacres.com",
    "main_image_url": null,
    "status": "active",
    "is_featured": false,
    "color": "#A3F2C1",
    "created_at": "2026-02-03T12:00:00.000000Z",
    "updated_at": "2026-02-03T12:00:00.000000Z",
    "amenities": [...]
  }
}
```

---

### Update Park

Updates an existing park.

**Endpoint:** `PUT /api/parks/{park_id}`

**Headers:**
```
Authorization: Bearer YOUR_BOT_API_TOKEN
Content-Type: application/json
```

**Request Body:**

Same fields as Create Park. All fields are optional - only include fields you want to update.

**Example Request:**

```bash
curl -X PUT https://your-domain.com/api/parks/123 \
  -H "Authorization: Bearer YOUR_BOT_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "description": "Updated description with new amenities.",
    "phone": "512-555-9999"
  }'
```

**Success Response (200 OK):**

```json
{
  "message": "Park updated successfully",
  "park": {
    "id": 123,
    "name": "Sunny Acres RV Park",
    ...
  }
}
```

---

## Error Responses

### 401 Unauthorized

Missing or invalid API token.

```json
{
  "message": "Unauthorized"
}
```

### 422 Validation Error

Invalid request data.

```json
{
  "message": "The name field is required.",
  "errors": {
    "name": ["The name field is required."]
  }
}
```

### 404 Not Found

Park not found (for update requests).

```json
{
  "message": "No query results for model [App\\Models\\Park] 999"
}
```

---

## Rate Limiting

API requests are limited to 60 requests per minute per IP address.

---

## Notes

- The `slug` and `slug_path` fields are auto-generated from the park name and location
- The `color` field is auto-generated as a random hex color
- When updating a park's name, the slug and slug_path are automatically regenerated
- Duplicate park names will have a numeric suffix added to the slug (e.g., "sunny-acres-rv-park-2")
