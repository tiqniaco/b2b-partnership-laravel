<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2B Partnership API Documentation</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui.css" />
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            margin:0;
            background: #fafafa;
        }
        .swagger-ui .topbar {
            background-color: #2c5aa0;
        }
        .swagger-ui .topbar .download-url-wrapper .select-label {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>

    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-standalone-preset.js"></script>

    <script>
        window.onload = function() {
            // Ensure the URL is absolute
            const baseUrl = window.location.origin;
            const yamlUrl = baseUrl + '/api-docs/openapi.yaml';

            console.log('Loading OpenAPI from:', yamlUrl);

            const ui = SwaggerUIBundle({
                url: yamlUrl,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                defaultModelsExpandDepth: 1,
                defaultModelExpandDepth: 1,
                docExpansion: "list",
                operationsSorter: "alpha",
                tagsSorter: "alpha",
                filter: true,
                syntaxHighlight: {
                    activate: true,
                    theme: "agate"
                },
                tryItOutEnabled: true,
                onComplete: function() {
                    console.log('Swagger UI loaded successfully');
                },
                onFailure: function(error) {
                    console.error('Swagger UI failed to load:', error);
                },
                requestInterceptor: function(request) {
                    // Auto-add base URL if not present
                    if (request.url.indexOf('http') !== 0) {
                        request.url = window.location.origin + '/api' + request.url;
                    }
                    return request;
                },
                responseInterceptor: function(response) {
                    return response;
                }
            });

            // Add custom header
            const header = document.createElement('div');
            header.innerHTML = `
                <div style="background: #2c5aa0; color: white; padding: 20px; text-align: center; margin-bottom: 20px;">
                    <h1 style="margin: 0; font-size: 2em;">B2B Partnership API</h1>
                    <p style="margin: 10px 0 0 0; opacity: 0.9;">Complete API documentation with interactive testing</p>
                    <div style="margin-top: 15px;">
                        <a href="/api-docs/postman.json" download style="color: #ffffff; text-decoration: none; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 4px; margin: 0 5px;">
                            📥 Download Postman Collection
                        </a>
                        <a href="/docs/README.md" target="_blank" style="color: #ffffff; text-decoration: none; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 4px; margin: 0 5px;">
                            📖 View Full Documentation
                        </a>
                    </div>
                </div>
            `;
            document.body.insertBefore(header, document.getElementById('swagger-ui'));
        };
    </script>
</body>
</html>
