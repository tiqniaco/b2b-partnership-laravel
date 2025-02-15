<?php
$query = "
CREATE OR REPLACE VIEW request_service_details_view AS
SELECT 
	request_services.id,
	request_services.title_ar,
    request_services.title_en,
    request_services.address,
    request_services.description,
    request_services.image,
    request_services.status,
    request_services.client_id,
    users.id AS user_id,
    users.name AS name,
    users.email AS email,
    users.country_code AS user_country_code,
    users.phone AS phone,
    users.image AS client_image,
    specializations.id AS specialization_id,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    sub_specializations.id AS sub_specialization_id,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en,
    countries.id AS country_id,
    countries.flag AS country_flag,
    countries.code AS country_code,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en,
    governments.id AS government_id,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    request_services.created_at AS created_at,
    request_services.updated_at AS updated_at
FROM 
    request_services
JOIN 
    clients ON request_services.client_id = clients.id 
JOIN 
    users ON clients.user_id = users.id
JOIN 
    sub_specializations ON request_services.sub_specialization_id = sub_specializations.id
JOIN 
    governments ON request_services.governments_id = governments.id
JOIN 
    countries ON governments.country_id = countries.id
JOIN 
    specializations ON sub_specializations.parent_id = specializations.id;
";
