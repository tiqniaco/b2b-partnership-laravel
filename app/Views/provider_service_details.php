<?php

$query = "
CREATE VIEW provider_service_details AS
SELECT 
    provider_services.id,
    provider_services.provider_id,
    provider_services.name_ar,
    provider_services.name_en,
    provider_services.address,
    provider_services.description,
    provider_services.image,
    provider_services.rating,
    provider_services.overview,
    provider_services.video,
    countries.id AS country_id,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en,
    provider_services.governments_id,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    specializations.id AS specialization_id,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    provider_services.sub_specialization_id,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en,
    provider_services.created_at,
    provider_services.updated_at
FROM 
    provider_services
JOIN 
    sub_specializations ON provider_services.sub_specialization_id = sub_specializations.id
JOIN 
    specializations ON sub_specializations.parent_id = specializations.id
JOIN 
    governments ON provider_services.governments_id = governments.id
JOIN 
    countries ON governments.country_id = countries.id;
";
