<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - RVParkHQ</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8f9fa; color: #1a1a2e; line-height: 1.6; }

        .api-header { background: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%); color: white; padding: 40px 0; }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 30px; }
        .api-header h1 { font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .api-header p { font-size: 16px; opacity: 0.9; }
        .api-header .base-url { background: rgba(255,255,255,0.15); padding: 10px 16px; border-radius: 8px; font-family: 'SF Mono', Monaco, monospace; font-size: 14px; margin-top: 16px; display: inline-block; }

        .api-content { padding: 40px 0 80px; }

        .section { background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 30px; overflow: hidden; }
        .section-header { padding: 24px 30px 16px; border-bottom: 1px solid #e5e7eb; }
        .section-header h2 { font-size: 22px; font-weight: 600; }
        .section-header p { color: #6b7280; margin-top: 4px; font-size: 14px; }
        .section-body { padding: 24px 30px; }

        .endpoint { border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 16px; overflow: hidden; }
        .endpoint:last-child { margin-bottom: 0; }
        .endpoint-header { display: flex; align-items: center; gap: 12px; padding: 14px 20px; background: #fafafa; cursor: pointer; user-select: none; }
        .endpoint-header:hover { background: #f3f4f6; }
        .method { font-family: 'SF Mono', Monaco, monospace; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
        .method-get { background: #dbeafe; color: #1d4ed8; }
        .method-post { background: #d1fae5; color: #059669; }
        .method-put { background: #fef3c7; color: #d97706; }
        .endpoint-path { font-family: 'SF Mono', Monaco, monospace; font-size: 14px; color: #374151; }
        .endpoint-desc { margin-left: auto; font-size: 13px; color: #6b7280; }
        .endpoint-body { padding: 20px; border-top: 1px solid #e5e7eb; display: none; }
        .endpoint.open .endpoint-body { display: block; }
        .endpoint-body h4 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; margin-bottom: 10px; margin-top: 16px; }
        .endpoint-body h4:first-child { margin-top: 0; }

        pre { background: #1e1e2e; color: #cdd6f4; padding: 16px 20px; border-radius: 8px; overflow-x: auto; font-size: 13px; line-height: 1.5; }
        code { font-family: 'SF Mono', Monaco, monospace; }
        p code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-size: 13px; color: #e11d48; }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table th { text-align: left; font-weight: 600; padding: 10px 12px; border-bottom: 2px solid #e5e7eb; color: #374151; font-size: 13px; }
        table td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; }
        table td:first-child { font-family: 'SF Mono', Monaco, monospace; font-size: 13px; color: #7c3aed; white-space: nowrap; }
        .required { color: #dc2626; font-size: 11px; font-weight: 600; }
        .optional { color: #9ca3af; font-size: 11px; }

        .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px 20px; margin-bottom: 16px; font-size: 14px; color: #1e40af; }
        .warn-box { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 8px; padding: 16px 20px; margin-bottom: 16px; font-size: 14px; color: #92400e; }

        .two-col { display: grid; grid-template-columns: 220px 1fr; gap: 30px; }
        .nav-sidebar { position: sticky; top: 20px; }
        .nav-sidebar a { display: block; padding: 8px 16px; color: #6b7280; text-decoration: none; font-size: 14px; border-left: 2px solid transparent; transition: all 0.15s; }
        .nav-sidebar a:hover { color: #2d6a4f; border-left-color: #2d6a4f; background: #f0fdf4; }
        @media (max-width: 768px) {
            .two-col { grid-template-columns: 1fr; }
            .nav-sidebar { display: none; }
            .api-header h1 { font-size: 24px; }
            .endpoint-desc { display: none; }
        }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 14px; margin-bottom: 16px; }
        .back-link:hover { color: white; }
    </style>
</head>
<body>

<div class="api-header">
    <div class="container">
        <a href="/" class="back-link">← Back to RVParkHQ</a>
        <h1>🏕️ RVParkHQ API</h1>
        <p>Programmatic access to RV park data — search, create, update, and enrich park listings.</p>
        <div class="base-url">https://rvparkhq.com/api</div>
    </div>
</div>

<div class="container api-content">
    <div class="two-col">
        <div>
            <nav class="nav-sidebar">
                <a href="#authentication">Authentication</a>
                <a href="#parks-search">Search Parks</a>
                <a href="#parks-create">Create Park</a>
                <a href="#parks-update">Update Park</a>
                <a href="#parks-enrich">Enrich Park</a>
                <a href="#amenities">Amenities</a>
                <a href="#data-schemas">Data Schemas</a>
            </nav>
        </div>

        <div>
            {{-- Authentication --}}
            <div class="section" id="authentication">
                <div class="section-header">
                    <h2>Authentication</h2>
                </div>
                <div class="section-body">
                    <p>All API endpoints require a Bearer token in the <code>Authorization</code> header.</p>
                    <pre><code>Authorization: Bearer YOUR_API_TOKEN</code></pre>
                    <p style="margin-top: 12px;">Contact the RVParkHQ team for API access.</p>
                </div>
            </div>

            {{-- Search Parks --}}
            <div class="section" id="parks-search">
                <div class="section-header">
                    <h2>Search Parks</h2>
                    <p>Find parks by name, location, slug, or ID.</p>
                </div>
                <div class="section-body">
                    <div class="endpoint open">
                        <div class="endpoint-header" onclick="this.parentElement.classList.toggle('open')">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/parks/search</span>
                            <span class="endpoint-desc">Search/lookup parks</span>
                        </div>
                        <div class="endpoint-body">
                            <h4>Query Parameters</h4>
                            <table>
                                <tr><th>Param</th><th>Type</th><th>Description</th></tr>
                                <tr><td>q</td><td>string</td><td><span class="optional">optional</span> Search by park name (partial match)</td></tr>
                                <tr><td>state</td><td>string</td><td><span class="optional">optional</span> Filter by state (e.g. "california" or "California")</td></tr>
                                <tr><td>city</td><td>string</td><td><span class="optional">optional</span> Filter by city</td></tr>
                                <tr><td>id</td><td>integer</td><td><span class="optional">optional</span> Lookup by park ID (returns single park with amenities + photos)</td></tr>
                                <tr><td>slug</td><td>string</td><td><span class="optional">optional</span> Lookup by slug (returns single park with amenities + photos)</td></tr>
                                <tr><td>limit</td><td>integer</td><td><span class="optional">optional</span> Max results (default 20, max 100)</td></tr>
                            </table>
                            <h4>Example: Search by name</h4>
                            <pre><code>curl -H "Authorization: Bearer TOKEN" \
  "https://rvparkhq.com/api/parks/search?q=pioneer&state=california"</code></pre>
                            <h4>Response</h4>
                            <pre><code>{
  "parks": [
    {
      "id": 1234,
      "name": "Pioneer RV Park",
      "slug": "pioneer-rv-park",
      "city": "Quincy",
      "state": "California",
      "phone": "(530) 283-0769",
      "website_url": "https://pioneerrvpark.com",
      "enrichment_updated_at": null
    }
  ],
  "count": 1
}</code></pre>
                            <h4>Example: Lookup by ID</h4>
                            <pre><code>curl -H "Authorization: Bearer TOKEN" \
  "https://rvparkhq.com/api/parks/search?id=1234"</code></pre>
                            <h4>Response</h4>
                            <pre><code>{
  "park": {
    "id": 1234,
    "name": "Pioneer RV Park",
    "slug": "pioneer-rv-park",
    "city": "Quincy",
    "state": "California",
    "rates": { ... },
    "facilities": [ ... ],
    "policies": { ... },
    "amenities": [ ... ],
    "park_photos": [ ... ]
  }
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Create Park --}}
            <div class="section" id="parks-create">
                <div class="section-header">
                    <h2>Create Park</h2>
                </div>
                <div class="section-body">
                    <div class="endpoint">
                        <div class="endpoint-header" onclick="this.parentElement.classList.toggle('open')">
                            <span class="method method-post">POST</span>
                            <span class="endpoint-path">/api/parks</span>
                            <span class="endpoint-desc">Create a new park listing</span>
                        </div>
                        <div class="endpoint-body">
                            <h4>Request Body</h4>
                            <table>
                                <tr><th>Field</th><th>Type</th><th>Description</th></tr>
                                <tr><td>name</td><td>string</td><td><span class="required">required</span> Park name</td></tr>
                                <tr><td>description</td><td>string</td><td><span class="optional">optional</span> Full description</td></tr>
                                <tr><td>short_description</td><td>string</td><td><span class="optional">optional</span> Max 500 chars</td></tr>
                                <tr><td>address</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>city</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>state</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>country</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>postal_code</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>latitude</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>longitude</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>phone</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>email</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>website_url</td><td>url</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>main_image_url</td><td>url</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>status</td><td>string</td><td><span class="optional">optional</span> "active" or "inactive" (default: active)</td></tr>
                                <tr><td>is_featured</td><td>boolean</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>amenity_ids</td><td>array</td><td><span class="optional">optional</span> Array of amenity IDs</td></tr>
                            </table>
                            <h4>Example</h4>
                            <pre><code>curl -X POST "https://rvparkhq.com/api/parks" \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Sunset RV Park",
    "city": "Austin",
    "state": "Texas",
    "country": "US",
    "phone": "(512) 555-0100"
  }'</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Park --}}
            <div class="section" id="parks-update">
                <div class="section-header">
                    <h2>Update Park</h2>
                </div>
                <div class="section-body">
                    <div class="endpoint">
                        <div class="endpoint-header" onclick="this.parentElement.classList.toggle('open')">
                            <span class="method method-put">PUT</span>
                            <span class="endpoint-path">/api/parks/{id}</span>
                            <span class="endpoint-desc">Update an existing park</span>
                        </div>
                        <div class="endpoint-body">
                            <p>Accepts the same fields as Create. Only include fields you want to change.</p>
                            <h4>Example</h4>
                            <pre><code>curl -X PUT "https://rvparkhq.com/api/parks/1234" \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"phone": "(530) 283-0769", "email": "info@pioneerrvpark.com"}'</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Enrich Park --}}
            <div class="section" id="parks-enrich">
                <div class="section-header">
                    <h2>Enrich Park</h2>
                    <p>Add detailed rates, facilities, policies, and metadata to a park. JSON fields are merged with existing data (not replaced).</p>
                </div>
                <div class="section-body">
                    <div class="endpoint open">
                        <div class="endpoint-header" onclick="this.parentElement.classList.toggle('open')">
                            <span class="method method-post">POST</span>
                            <span class="endpoint-path">/api/parks/{id}/enrich</span>
                            <span class="endpoint-desc">Enrich a park with detailed data</span>
                        </div>
                        <div class="endpoint-body">
                            <h4>Request Body</h4>
                            <table>
                                <tr><th>Field</th><th>Type</th><th>Description</th></tr>
                                <tr><td>rates</td><td>object</td><td><span class="optional">optional</span> Rate data (see schema below)</td></tr>
                                <tr><td>facilities</td><td>array</td><td><span class="optional">optional</span> Facility list (see schema below)</td></tr>
                                <tr><td>site_types</td><td>array</td><td><span class="optional">optional</span> Site type details</td></tr>
                                <tr><td>policies</td><td>object</td><td><span class="optional">optional</span> Park policies (see schema below)</td></tr>
                                <tr><td>manager_name</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>total_sites</td><td>integer</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>acreage</td><td>number</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>reservation_url</td><td>url</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>facebook_url</td><td>url</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>description</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>phone</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>email</td><td>string</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>website_url</td><td>url</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>hours_of_operation</td><td>array</td><td><span class="optional">optional</span></td></tr>
                                <tr><td>amenity_ids</td><td>array</td><td><span class="optional">optional</span> Amenity IDs to attach (additive, won't remove existing)</td></tr>
                                <tr><td>enrichment_source</td><td>string</td><td><span class="optional">optional</span> e.g. "manual", "ahfaz", "hermes"</td></tr>
                            </table>
                            <h4>Example</h4>
                            <pre><code>curl -X POST "https://rvparkhq.com/api/parks/1234/enrich" \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "rates": {
      "nightly": [
        {"type": "Pull-Thru", "price": "$55/night", "season": "Peak (May-Oct)"},
        {"type": "Back-In 30/50", "price": "$50/night", "season": "Peak (May-Oct)"},
        {"type": "Pull-Thru", "price": "$45/night", "season": "Off-Season (Nov-Apr)"}
      ],
      "monthly": [
        {"type": "Standard", "price": "$625/month", "notes": "Plus electricity"}
      ],
      "additional": [
        {"name": "Extra person/day", "price": "$10"},
        {"name": "Dump fee", "price": "$10"}
      ],
      "notes": "Kids 17 and under are free"
    },
    "facilities": [
      {"name": "Free WiFi", "category": "Connectivity"},
      {"name": "Laundry Room", "category": "Services"},
      {"name": "Swimming Pool", "category": "Recreation"},
      {"name": "Dog Wash Station", "category": "Pet Friendly"},
      {"name": "Dump Station", "category": "RV Services"},
      {"name": "Propane", "category": "RV Services"}
    ],
    "policies": {
      "pets": "Pets welcome, must be leashed. Dog wash station available.",
      "cancellation": "$100 non-refundable deposit for stays 30+ nights",
      "check_in": "Check-in: 2:00 PM, Check-out: 11:00 AM",
      "quiet_hours": "10:00 PM - 8:00 AM",
      "max_guests": "Maximum 6 people per site",
      "deposit": "$100 electric deposit for monthly stays"
    },
    "manager_name": "Kyle and Shateka Palmer",
    "total_sites": 50,
    "acreage": 6.5,
    "reservation_url": "https://www.campspot.com/book/pioneerrvpark",
    "facebook_url": "https://www.facebook.com/Pioneer-RV-Park-118673428162913/",
    "enrichment_source": "manual"
  }'</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Amenities --}}
            <div class="section" id="amenities">
                <div class="section-header">
                    <h2>Amenities</h2>
                    <p>List available amenities and their IDs for use when creating/enriching parks.</p>
                </div>
                <div class="section-body">
                    <div class="endpoint">
                        <div class="endpoint-header" onclick="this.parentElement.classList.toggle('open')">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/amenities</span>
                            <span class="endpoint-desc">List all amenities</span>
                        </div>
                        <div class="endpoint-body">
                            <h4>Response</h4>
                            <pre><code>{
  "amenities": [
    {"id": 1, "amenity": "Full Hookups", "category": "RV Services"},
    {"id": 2, "amenity": "WiFi", "category": "Connectivity"},
    {"id": 3, "amenity": "Pool", "category": "Recreation"},
    ...
  ]
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Schemas --}}
            <div class="section" id="data-schemas">
                <div class="section-header">
                    <h2>Data Schemas</h2>
                    <p>Reference schemas for the JSON fields used in enrichment.</p>
                </div>
                <div class="section-body">
                    <h4>Rates Object</h4>
                    <pre><code>{
  "nightly": [{"type": "string", "price": "string", "season": "string"}],
  "weekly":  [{"type": "string", "price": "string", "notes": "string"}],
  "monthly": [{"type": "string", "price": "string", "notes": "string"}],
  "seasonal":[{"name": "string", "dates": "string", "price": "string"}],
  "additional":[{"name": "string", "price": "string"}],
  "notes": "string"
}</code></pre>

                    <h4>Facilities Array</h4>
                    <pre><code>[
  {
    "name": "Free WiFi",
    "category": "Connectivity|Services|Recreation|Pet Friendly|RV Services|General",
    "details": "Optional extra info"
  }
]</code></pre>

                    <h4>Policies Object</h4>
                    <pre><code>{
  "pets": "string",
  "cancellation": "string",
  "check_in": "string",
  "quiet_hours": "string",
  "max_guests": "string",
  "age_restrictions": "string",
  "fires": "string",
  "deposit": "string",
  "other": ["string"] or "string"
}</code></pre>

                    <h4>Site Types Array</h4>
                    <pre><code>[
  {
    "type": "Pull-Through",
    "hookups": "Full (Water/Sewer/Electric)",
    "amps": "30/50",
    "max_length": "45ft",
    "count": 20,
    "surface": "Gravel"
  }
]</code></pre>

                    <div class="info-box" style="margin-top: 20px;">
                        <strong>Tip:</strong> JSON fields in the enrich endpoint are <strong>merged</strong> with existing data. To clear a field, explicitly set it to <code>null</code> or an empty object/array.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('.nav-sidebar a').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        document.querySelector(a.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>

</body>
</html>
