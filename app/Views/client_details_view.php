<?php

$query = "
CREATE VIEW client_details_view AS
SELECT 
    users.id AS user_id,
    users.name AS name,
    users.email AS email,
    users.country_code AS country_code,
    users.phone AS phone,
    users.image AS image,
    clients.id AS client_id,
    countries.id AS country_id,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en,
    governments.id AS government_id,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    clients.created_at AS created_at,
    clients.updated_at AS updated_at
FROM 
    clients
JOIN 
    users ON clients.user_id = users.id
JOIN 
    governments ON clients.governments_id = governments.id
JOIN 
    countries ON governments.country_id = countries.id;
    
    ";
